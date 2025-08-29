<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('auth_user')) {
    function auth_user()
    {
        return Auth::user();
    }
}

if (! function_exists('all_users')) {
    function all_users()
    {
        return User::all();
    }
}
