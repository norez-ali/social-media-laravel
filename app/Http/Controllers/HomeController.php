<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::with(['profile', 'posts'])
            ->get();
        return view('index', get_defined_vars());
    }
}
