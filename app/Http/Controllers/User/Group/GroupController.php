<?php

namespace App\Http\Controllers\User\Group;

use App\Http\Controllers\Controller;
use App\Models\User\Group\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('user.groups.index');
        }
        return view('user.groups.search-bar-group');
    }
    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('user.groups.create-group');
        }
        return view('user.groups.search-bar-create-group');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'privacy'     => 'required|in:public,private',
        ]);

        $group = Group::create([
            'user_id'     => auth_user()->id,
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'privacy'     => $validated['privacy'],
        ]);


        return redirect()->route('user.popular.group');
    }
}
