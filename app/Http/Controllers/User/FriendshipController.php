<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Friendship;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    public function sendRequest($receiverId)
    {
        $user = auth_user();

        // Prevent sending request to yourself
        if ($user->id == $receiverId) {
            return response()->json(['error' => 'You cannot send a request to yourself.'], 400);
        }

        // Check if request already exists
        $exists = Friendship::where(function ($q) use ($user, $receiverId) {
            $q->where('sender_id', $user->id)->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($user, $receiverId) {
            $q->where('sender_id', $receiverId)->where('receiver_id', $user->id);
        })->exists();

        if ($exists) {
            return response()->json(['error' => 'Friend request already exists.'], 400);
        }

        Friendship::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'status' => 'pending'
        ]);

        return response()->json(['success' => 'Friend request sent.']);
    }
    public function cancelRequest($receiverId)
    {
        $friendRequest = Friendship::where('sender_id', auth()->id())
            ->where('receiver_id', $receiverId)
            ->first();

        if ($friendRequest) {
            $friendRequest->delete();

            return response()->json([
                'success' => 'Friend request cancelled successfully.'
            ]);
        }

        return response()->json([
            'error' => 'No friend request found to cancel.'
        ], 404);
    }
}
