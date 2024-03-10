<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\CreateChatRequest;
use App\Http\Resources\ChatResource;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function createChat(CreateChatRequest $request)
    {
        $users = $request->users;
        // check if users had chat before
        $chat = $request->user()->chats()->whereHas('participants', function ($q) use ($users) {
            $q->where('user_id', $users[0]);
        })->first();

        // if not, create new one
        if (empty($chats)) {
            array_push($users, $request->user()->id);
            $chat = Chat::create()->makePrivate($request->isPrivate);
            $chat->participants->attach($users);
        }

        $success = true;
        return response()->json([
            'chat' => new ChatResource($chat),
            'success' => $success
        ], 200);
    }
}
