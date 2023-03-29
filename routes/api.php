<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/posts', [PostController::class,'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::post('/posts', [PostController::class, 'store']);

    Route::delete('/comment/{id}', [CommentController::class, 'delete'])->middleware('comment.owner');
});


Route::patch('/posts/{id}', [PostController::class, 'update'])->middleware(['auth:sanctum','post.owner']);
Route::delete('/posts/{id}', [PostController::class, 'delete'])->middleware(['auth:sanctum','post.owner']);

Route::post('/comment', [CommentController::class, 'store'])->middleware(['auth:sanctum']);
Route::patch('/comment/{id}', [CommentController::class, 'update'])->middleware(['auth:sanctum','comment.owner']);


Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthenticationController::class, 'saya'])->middleware('auth:sanctum');