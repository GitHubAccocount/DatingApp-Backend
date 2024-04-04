<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Events\ChatMessageStatus;
use App\Http\Requests\Chat\CreateChatRequest;
use App\Http\Requests\Chat\SendTextMessageRequest;
use App\Http\Resources\ChatResource;
use App\Http\Resources\MassageResource;
use App\Models\Chat;
use App\Models\ChatMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function createChat(CreateChatRequest $request)
    {
        // Get users participating in the chat
        $users = $request->users;
        // Check if users have a chat history
        $chat = $request->user()->chats()->whereHas('participants', function ($q) use ($users) {
            $q->where('user_id', $users[0]);
        })->first();

        // If no chat history, create a new chat
        if (empty($chat)) {
            array_push($users, $request->user()->id);
            $chat = Chat::create()->makePrivate($request->isPrivate);
            $chat->participants()->attach($users);
        }

        return response()->json([
            'chat' => new ChatResource($chat),
            'success' => true
        ], 200);
    }

    public function getChats(Request $request)
    {
        $user = $request->user();

        // Retrieve chats with participants and last message with 'delivered' status
        $chats = $user->chats()
            ->with('participants')
            ->with(['messages' => function ($query) {
                $query->whereRaw("JSON_EXTRACT(data, '$.status') = 'delivered'")
                    ->orderBy('created_at', 'desc')
                    ->limit(1);
            }])
            ->get();

        // Return a JSON response containing chats
        return response()->json([
            'chats' => $chats,
            'success' => true
        ]);
    }

    public function sendTextMessage(SendTextMessageRequest $request)
    {
        // Find the chat by ID
        $chat = Chat::find($request->chat_id);

        // Check if the user is a participant in the chat
        if ($chat->isParticipant($request->user()->id)) {
            // Create a new chat message
            $message = ChatMessages::create([
                'message' => $request->message,
                'chat_id' => $request->chat_id,
                'user_id' => $request->user()->id,
                'data' => json_encode(['seenBy' => [], 'status' => 'sent'])
            ]);

            $message = new MassageResource($message);

            // Broadcast the ChatMessageSent event
            broadcast(new ChatMessageSent($message));

            return response()->json([
                'message' => $message,
                'success' => true
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }
    }

    public function messageStatus(Request $request, ChatMessages $message)
    {
        if ($message->chat->isParticipant($request->user()->id)) {
            $messageData = json_decode($message->data);
            array_push($messageData->seenBy, $request->user()->id);
            $messageData->seenBy = array_unique($messageData->seenBy);

            if (count($message->chat->participants) == count($messageData->seenBy)) {
                $messageData->status = 'seen';
            } else {
                $messageData->status = 'delivered';
            }

            $message->data = json_encode($messageData);
            $message->save();
            $message = new MassageResource($message);

            broadcast(new ChatMessageStatus($message));

            return response()->json([
                'message' => $message,
                'success' => true,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'success' => false
            ], 404);
        }
    }

    public function getChatById(Chat $chat, Request $request)
    {
        $user = $request->user();

        // Check if the user is a participant in the chat
        if ($chat->isParticipant($user->id)) {
            // Update the last seen timestamp of the user
            $user->last_seen_at = now();
            $user->save();

            // Set all messages in the chat as seen for the user
            $this->setStatusAsSeenForAllMessages($chat, $request);

            // Retrieve messages of the chat with sender information, ordered by creation time
            $messages = $chat->messages()->with('sender')->orderBy('created_at', 'asc')->paginate('150');

            // Return a JSON response containing the chat and its messages
            return response()->json([
                'chat' => new ChatResource($chat),
                'messages' => MassageResource::collection($messages)->response()->getData(true)
            ], 200);
        } else {
            // Return a JSON response with a "Not Found" message if the user is not a participant in the chat
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function setStatusAsSeenForAllMessages(Chat $chat, Request $request)
    {
        $chat->messages()
            // Messages not sent by the user
            ->where('user_id', '<>', $request->user()->id)
            // Messages created after last user visit
            ->where('created_at', '<', $request->user()->last_seen_at)
            // Messages with status different than 'seen'
            ->whereRaw("JSON_EXTRACT(data, '$.status') <> 'seen'")
            ->update(['data' => DB::raw("JSON_SET(data, '$.status', 'seen')")]);
    }
}
