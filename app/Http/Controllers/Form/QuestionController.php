<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(): JsonResponse
    {
        // Retrieve all questions from the database
        $questions =  Question::all();

        // Return a JSON response containing all questions
        return response()->json($questions);
    }
}
