<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::with([
            'profile',
            'posts' => function ($query) {
                $query->withCount('likes')   // total likes count
                    ->with(['likes.user']); // details of users who liked
            }
        ])->get();

        return view('index', get_defined_vars());
    }
}
