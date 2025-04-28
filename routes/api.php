<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserContoller;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/posts-all', [PostController::class, 'postlist']);
Route::get('/posts/{post}', [PostController::class, 'show']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/users/roles', [UserContoller::class, 'roles']);


    Route::post('/posts/update', [PostController::class, 'update']);
    
    Route::apiResource('users', UserContoller::class);
    Route::apiResource('posts', PostController::class)->except(['show']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('comments', CommentController::class);
    
});

