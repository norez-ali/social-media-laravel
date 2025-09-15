<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        $users = User::with([
            'profile',
            'stories',
            'posts' => function ($query) {
                $query->withCount('likes')
                    ->with(['likes.user', 'comments.user.profile']);
            },
        ])->get();

        return view('index', get_defined_vars());
    }
}
