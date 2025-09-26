<?php

namespace App\Http\Controllers\User\Group;

use App\Http\Controllers\Controller;
use App\Models\User\Group\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupMemberController extends Controller
{
    public function join(Request $request, $id)
    {

        $user = auth()->user();
        $group = Group::findOrFail($id);

        // Determine status based on privacy
        $status = $group->privacy === 'public' ? 'approved' : 'pending';

        // Attach or update pivot
        $user->groups()->syncWithoutDetaching([
            $group->id => ['status' => $status, 'role' => 'member']
        ]);


        return response()->json([
            'success' => true,
            'status' => $status,
        ]);
    }
    public function leave($id)
    {
        $user = auth()->user();
        $group = Group::find($id);

        // Check if the user is a member
        $isMember = $user->groups()->where('group_id', $id)->exists();

        if ($isMember) {
            $user->groups()->detach($id);

            return response()->json([
                'success' => true,
                'status' => 'left',
                'privacy' => $group->privacy, // 👈 include privacy info
                'message' => 'You have left the group.',
            ]);
        }

        return response()->json([
            'success' => false,
            'status' => 'not_member',
            'message' => 'You are not a member of this group.',
        ], 400);
    }
    public function viewRequests($groupId, Request $request)
    {
        // Find group with members
        $group = Group::with('members.profile')->findOrFail($groupId);

        // Ensure logged-in user is an admin of this group
        $isAdmin = $group->members()
            ->wherePivot('role', 'admin')
            ->where('users.id', auth()->id())
            ->exists();

        if (!$isAdmin) {
            abort(403, 'Unauthorized action.');
        }

        // Get only pending requests
        $pendingRequests = $group->members()
            ->wherePivot('status', 'pending')
            ->with('profile')
            ->get();



        return view('user.groups.open-group.nav.requests', compact('group', 'pendingRequests'));
    }
    public function approve(Request $request)
    {
        $data = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'user_id'  => 'required|exists:users,id',
        ]);

        $group = Group::findOrFail($data['group_id']);
        $currentUser = $group->members->firstWhere('id', Auth::id());

        if (!$currentUser || $currentUser->pivot->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        // Update status on the pivot
        $group->members()->updateExistingPivot($data['user_id'], [
            'status' => 'approved',
        ]);

        return response()->json(['success' => true, 'message' => 'Request approved successfully.']);
    }
    public function reject(Request $request)
    {
        $data = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'user_id'  => 'required|exists:users,id',
        ]);

        $group = Group::findOrFail($data['group_id']);
        $currentUser = $group->members->firstWhere('id', Auth::id());

        if (!$currentUser || $currentUser->pivot->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        // Detach the user from the group (removes pivot row)
        $group->members()->detach($data['user_id']);

        return response()->json(['success' => true, 'message' => 'Request rejected successfully.']);
    }
    public function viewMembers($groupId, Request $request)
    {
        // Load group with members (only approved)
        $group = Group::with(['members' => function ($query) {
            $query->wherePivot('status', 'approved')
                ->with('profile'); // if you have a profile relation
        }])->findOrFail($groupId);
        $currentUser = $group->members->firstWhere('id', auth()->id());

        // Get approved members
        $members = $group->members;



        // Default full-page view
        return view('user.groups.open-group.nav.members', get_defined_vars());
    }
}
