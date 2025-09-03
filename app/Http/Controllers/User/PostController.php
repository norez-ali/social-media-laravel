<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Post;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validation
        $request->validate([
            'content' => 'nullable|string|max:1000',
            'media.*' => 'nullable|mimes:jpg,jpeg,png,gif,bmp,svg,webp,mp4,mov,avi,mkv,webm,wmv,flv,mpeg|max:10240', // 10MB
        ]);

        // Create post
        $post = new Post();
        $post->user_id = $user->id;
        $post->content = $request->content ?? null;
        $post->save();

        // Handle media if uploaded
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                // Get file extension + media type
                $extension = strtolower($file->getClientOriginalExtension());
                $mediaType = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']) ? 'image' : 'video';

                // Unique file name
                $filename = time() . '_' . uniqid() . '.' . $extension;

                // Move file to public/images/posts
                $file->move(public_path('images/posts'), $filename);

                // Save media info to post (if you want multiple, use a separate PostMedia table)
                $post->media = $filename;
                $post->media_type = $mediaType;
                $post->save();
            }
        }

        return response()->json([
            'success' => true,
            'post' => $post
        ]);
    }
}
