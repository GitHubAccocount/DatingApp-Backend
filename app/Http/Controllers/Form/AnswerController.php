<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Rules\SelectedAnswerValidationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        // Prevent empty form submission
        if (empty($request->all())) {
            return response()->json([
                'errors' => 'You need to answers the statements.'
            ], 422);
        }

        // Get the number of questions
        $questionsCount = Question::count();

        // Define validation rules for each question
        $rules = [];
        for ($i = 0; $i < $questionsCount; $i++) {
            $rules["$i.id"] = 'required|numeric';
            $rules["$i.selectedAnswer"] = ['required', 'string', new SelectedAnswerValidationRule];
        }

        // Validate the incoming request data
        $validated = $request->validate($rules);

        // Get the ID of the authenticated user
        $userId = auth()->id();

        // Ensure user has not previously answered the questions
        $user = User::find($userId);
        if (!$user->answer()->exists()) {
            $answers = [];
            foreach ($validated as $item) {
                $answers[] = [
                    'user_id' => $userId,
                    'question_id' => $item['id'],
                    'answer' => $item['selectedAnswer'],
                ];
            }

            // Insert answers into the database
            DB::table('answers')->insert($answers);

            return response()->noContent();
        }
    }

    public function getFormSubmissionState()
    {
        // Get the ID of the authenticated user
        $userId = auth()->id();
        // Check if answers exist for the user
        // If one answer exists, all of them should exist
        $answers = Answer::where('user_id', $userId)->exists();

        // Return a JSON response indicating whether the form has been submitted
        return response()->json([
            'submitted' => $answers,
        ]);
    }
}
