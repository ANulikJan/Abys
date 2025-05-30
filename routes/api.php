<?php

use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [UserController::class, 'registerByEmail']);
Route::post('/auth/login-link', [MagicLinkController::class, 'sendLink']);
Route::get('/auth/login/{token}', [MagicLinkController::class, 'verifyToken']);

Route::middleware('auth:sanctum')->prefix('questions')->group(function () {
    Route::get('/answers', [QuestionController::class, 'getMyAnswers']);
    Route::get('/', [QuestionController::class, 'index']);
    Route::get('/{question:uuid}', [QuestionController::class, 'getQuestion']);
    Route::get('/{question:uuid}/answers', [QuestionController::class, 'getQuestionMyAnswers']);
    Route::post('/{question:uuid}/answer', [QuestionController::class, 'answerToQuestion']);
    Route::post('/{question:uuid}/{answer:uuid}', [QuestionController::class, 'updateQuestionAnswer']);
});



