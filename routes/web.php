<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ProfileController;

// only the users with verified emails can access these routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    //route ajax home
    Route::get('home', [HomeController::class, 'ajaxHome'])->name('ajax.home');
});





require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/group.php';
