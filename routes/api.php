<?php

use App\Http\Controllers\Form\AnswerController;
use App\Http\Controllers\Form\PersonalInformationController;
use App\Http\Controllers\Form\QuestionController;
use App\Http\Controllers\Match\MatchController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/questions', [QuestionController::class, 'index'])->middleware(['auth:sanctum', 'emapthy.not.done']);
Route::post('/answers', [AnswerController::class, 'store'])->middleware(['auth:sanctum', 'emapthy.not.done']);
Route::get('/answers/get-form-submission-state', [AnswerController::class, 'getFormSubmissionState'])->middleware(['auth:sanctum']);

// Route::get('/points', [AnswerController::class, 'points']);

Route::post('/personal-informations', [PersonalInformationController::class, 'store'])->middleware(['auth:sanctum', 'personalInfo.not.done']);
Route::get('/personal-informations/get-form-submission-state', [PersonalInformationController::class, 'getFormSubmissionState'])->middleware(['auth:sanctum']);

Route::get('/matched-users', [MatchController::class, 'index'])->middleware('auth:sanctum');

Route::put('/update-user', [UserController::class, 'update'])->middleware('auth:sanctum');
