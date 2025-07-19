<?php

use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CommentController;

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);
Route::post('/news', [NewsController::class, 'store']);
Route::delete('/news/{id}', [NewsController::class, 'destroy']);
Route::post('/news/{id}/like', [NewsController::class, 'like']);

// Comments
Route::get('/news/{id}/comments', [CommentController::class, 'index']);
Route::post('/news/{id}/comments', [CommentController::class, 'store']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
