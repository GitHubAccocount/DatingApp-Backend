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
        // prevent against empty form submission
        if (empty($request->all())) {
            return response()->json([
                'errors' => 'You need to answers the statements.'
            ], 422);
        }

        // get number of questions
        $questionsCount = Question::count();

        // for each question there is a rule
        $rules = [];
        for ($i = 0; $i < $questionsCount; $i++) {
            $rules["$i.id"] = 'required|numeric';
            $rules["$i.selectedAnswer"] = ['required', 'string', new SelectedAnswerValidationRule];
        }

        $validated = $request->validate($rules);

        $userId = auth()->id();

        // user can answers the questions only if naver has done it before
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

            DB::table('answers')->insert($answers);

            return response()->noContent();
        }
    }

    public function getFormSubmissionState()
    {
        $userId = auth()->id();
        $answers = Answer::where('user_id', $userId)->exists();

        return response()->json([
            'submitted' => $answers,
        ]);
    }
}
