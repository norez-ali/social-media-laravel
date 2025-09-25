<?php

namespace App\Http\Controllers\User\Group;

use App\Http\Controllers\Controller;
use App\Models\User\Group\Group;
use Illuminate\Http\Request;

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
}
