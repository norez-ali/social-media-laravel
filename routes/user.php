<?php

use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

// all the routes related to user functionalities will be here
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('user-profile', [ProfileController::class, 'index'])->name('user.profile');
});
