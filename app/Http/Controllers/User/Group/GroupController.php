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
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $group = new Group();
        $group->name = $request->name;
        $group->description = $request->description;
        $group->privacy = $request->privacy;
        $group->user_id = auth_user()->id;

        if ($request->hasFile('cover_photo')) {
            $path = $request->file('cover_photo')->store('groups/covers', 'public');
            $group->cover_photo = $path;
        }
        $group->save();
        $group->members()->attach(auth_user()->id, ['role' => 'admin', 'status' => 'approved']);

        $html = view('user.groups.search-bar-group')->render();
        return response()->json([
            'success' => true,
            'html' => $html // send the URL
        ]);
    }
    public function myGroups(Request $request)
    {
        $groups = auth()->user()->groups()->latest()->get();
        if ($request->ajax()) {

            return view('user.groups.my-groups', get_defined_vars());
        }
        return view('user.groups.search-bar-my-groups', get_defined_vars());
    }
    public function viewGroup(Request $request, $id)
    {
        $group = Group::with(['members' => function ($query) {
            $query->with('profile'); // if you have a profile relation
        }])->find($id);
        // Get the logged-in user’s membership row for this group
        $currentUser = $group->members->firstWhere('id', auth()->id());

        return view('user.groups.open-group.view-group', get_defined_vars());
    }
}
