<?php

use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CommentController;

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);
Route::post('/news/{id}/like', [NewsController::class, 'like']);

Route::post('/news/{id}/comments', [CommentController::class, 'store']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);