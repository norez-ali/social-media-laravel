<?php

namespace App\Http\Controllers\User\Group;

use App\Http\Controllers\Controller;
use App\Models\User\Group\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Get IDs of groups the user already belongs to
        $joinedGroupIds = $user->groups()->pluck('groups.id')->toArray();

        // Fetch 10 random groups excluding those
        $groups = Group::whereNotIn('id', $joinedGroupIds)
            ->inRandomOrder()
            ->take(10)
            ->get();
        if ($request->ajax()) {
            return view('user.groups.index', get_defined_vars());
        }
        return view('user.groups.search-bar-group', get_defined_vars());
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


        return response()->json([
            'redirect' => route('user.popular.group'),
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
        // Get all pending join requests for THIS group only
        if ($request->ajax()) {
            return view('user.groups.open-group.view-group', get_defined_vars());
        }
        return view('user.groups.open-group.search-bar-view-group', get_defined_vars());
    }
    public function destroy($groupId)
    {
        $group = Group::with('members')->findOrFail($groupId);
        $path = str_replace('storage/', '', $group->cover_photo);
        // Delete cover photo if exists
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // Detach all members
        $group->members()->detach();

        // Delete the group itself
        $group->delete();

        return response()->json([
            'message' => 'Group deleted successfully.',
            'redirect' => route('user.popular.group'),
        ]);
    }
    public function updateCover(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        if ($group->cover_photo) {
            // Remove any "storage/" prefix just in case
            $path = str_replace('storage/', '', $group->cover_photo);

            // Delete cover photo if exists
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            // Save new one
            $path = $request->file('cover_photo')->store('groups/covers', 'public');
            $group->cover_photo = $path;
            $group->save();
        }

        return response()->json([
            'success' => true,
            'cover_photo_url' => asset('storage/' . $group->cover_photo),
        ]);
    }
}
