<?php

use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\LikeController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

// all the routes related to user functionalities will be here
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('user-profile/{id}', [ProfileController::class, 'index'])->name('user.profile');
    Route::put('update-profile', [ProfileController::class, 'updateProfile'])->name('user.updateProfile');
    Route::get('user-photos', [ProfileController::class, 'photos'])->name('user.profile.photos');

    // Route for creating a post
    Route::post('create-post', [PostController::class, 'store'])->name('user.create.post');
    Route::delete('delete-post/{id}', [PostController::class, 'destroy'])->name('user.delete.post');

    // Route for liking a post
    Route::post('post-like/{postId}', [LikeController::class, 'like'])->name('user.like.post');

    // Route for  comment to a post
    Route::post('add-comment/{postId}', [CommentController::class, 'store'])->name('user.add.comment');
    Route::delete('delete-comment/{id}', [CommentController::class, 'destroy'])->name('user.delete.comment');
});
