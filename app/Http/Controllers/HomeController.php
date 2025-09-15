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
            'stories' => function ($query) {
                $query->where('expires_at', '>', now())  // only valid stories
                    ->latest()
                    ->limit(1); // ✅ only the first/latest
            },
            'posts' => function ($query) {
                $query->withCount('likes')
                    ->with(['likes.user', 'comments.user.profile']);
            },
        ])->get();


        return view('index', get_defined_vars());
    }
}
