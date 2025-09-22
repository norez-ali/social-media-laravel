<?php

use App\Http\Controllers\User\Group\GroupController;
use Illuminate\Support\Facades\Route;

// all the routes related to group functionalities functionalities will be here
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('popular-group', [GroupController::class, 'index'])->name('user.popular.group');
    Route::get('new-group', [GroupController::class, 'create'])->name('user.create.group');
    Route::post('store-group', [GroupController::class, 'store'])->name('user.store.group');
});
