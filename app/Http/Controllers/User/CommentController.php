<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = Comment::create([
            'user_id' => auth_user()->id,
            'post_id' => $postId,
            'content' => $request->content,
        ]);

        // Load relationship for AJAX response
        $comment->load('user.profile');

        return response()->json([
            'success' => true,
            'comment' => [
                'user_name' => $comment->user->name,
                'profile_photo' => $comment->user->profile->profile_photo
                    ? asset('storage/profile_photos/' . $comment->user->profile->profile_photo)
                    : asset('assets/images/user-7.png'),
                'text' => $comment->content,
                'time' => $comment->created_at->diffForHumans(),
            ]
        ]);
    }
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        // Ensure the authenticated user is the owner of the comment
        if ($comment->user_id !== auth_user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['success' => true]);
    }
}
