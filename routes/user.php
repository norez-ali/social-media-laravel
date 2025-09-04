<?php

use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

// all the routes related to user functionalities will be here
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('user-profile/{id}', [ProfileController::class, 'index'])->name('user.profile');
    Route::put('update-profile', [ProfileController::class, 'updateProfile'])->name('user.updateProfile');

    // Route for creating a post
    Route::post('create-post', [PostController::class, 'store'])->name('user.create.post');
    Route::delete('delete-post/{id}', [PostController::class, 'destroy'])->name('user.delete.post');
});
