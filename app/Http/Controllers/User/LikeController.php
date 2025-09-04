<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, $postId)
    {
        $user = auth_user();
        $post = Post::findOrFail($postId);

        $like = $post->likes()->where('user_id', $user->id)->first();

        if ($like) {
            // Unlike
            $like->delete();
            $liked = false;
        } else {
            // Like
            $post->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count(),
        ]);
    }
}
