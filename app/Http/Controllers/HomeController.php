<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User\Story;
use App\Models\User\Friendship;
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
                $query->withCount(['likes', 'comments'])
                    ->with(['likes.user', 'comments.user.profile']);
            },
        ])->get();

        $requests = Friendship::with(['sender.profile'])
            ->where('receiver_id', auth_user()->id)   // current user is the receiver
            ->where('status', 'pending')           // only pending requests
            ->get();

        $suggested_users = User::with('profile')
            ->suggestions(auth_user()->id) // matches the scopeSuggestions
            ->inRandomOrder()             // randomize
            ->take(8)
            ->get();



        return view('index', get_defined_vars());
    }
}
