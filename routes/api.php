<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\RankingController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('dni.auth')->group(function () {
    Route::get('exams', [ExamController::class, 'index']);
    Route::get('exams/{exam}/questions', [ExamController::class, 'questions']);
    Route::post('exams/{exam}/submit', [ExamController::class, 'submit']);
    Route::get('scores', [ScoreController::class, 'index']);
    Route::get('ranking', [RankingController::class, 'index']);
});
