<?php

use App\Http\Controllers\User\Group\GroupController;
use App\Http\Controllers\User\Group\GroupMemberController;
use Illuminate\Support\Facades\Route;

// all the routes related to group functionalities functionalities will be here
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('popular-group', [GroupController::class, 'index'])->name('user.popular.group');
    Route::get('new-group', [GroupController::class, 'create'])->name('user.create.group');
    Route::post('store-group', [GroupController::class, 'store'])->name('user.store.group');
    Route::delete('admin-group-delete/{groupId}', [GroupController::class, 'destroy'])->name('admin.delete.group');
    Route::put('edit-group-cover/{groupId}', [GroupController::class, 'updateCover'])->name('admin.update.group.cover');
    Route::get('my-groups', [GroupController::class, 'myGroups'])->name('user.my.groups');
    Route::get('view-group/{id}', [GroupController::class, 'viewGroup'])->name('user.view.group');

    //route for joining the group
    Route::post('join-group/{groupId}', [GroupMemberController::class, 'join'])->name('user.join.group');
    Route::delete('leave-group/{groupId}', [GroupMemberController::class, 'leave'])->name('user.leave.group');
    //for viewing pending requests for group admins
    Route::get('view-requests/{groupId}', [GroupMemberController::class, 'viewRequests'])->name('admin.view.requests');
    //for accepting request and rejecting request
    Route::post('approve-request', [GroupMemberController::class, 'approve'])
        ->name('user.approve.request');
    Route::post('reject-request', [GroupMemberController::class, 'reject'])->name('user.reject.request');
});
