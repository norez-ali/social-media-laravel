<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Post;
use Illuminate\Support\Facades\Storage;

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

        $mediaFiles = [];

        // Handle media if uploaded
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                // Get file extension + media type
                $extension = strtolower($file->getClientOriginalExtension());
                $mediaType = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']) ? 'image' : 'video';

                // Unique file name
                $filename = time() . '_' . uniqid() . '.' . $extension;

                // Store file in storage/app/public/posts folder
                $file->storeAs('posts', $filename, 'public');

                // Add to media files array
                $mediaFiles[] = [
                    'filename' => $filename,
                    'type' => $mediaType,
                    'url' => asset('storage/posts/' . $filename)
                ];

                // If you want to save only the first media to the post table
                if (empty($post->media)) {
                    $post->media = $filename;
                    $post->media_type = $mediaType;
                    $post->save();
                }

                // Alternative: Create PostMedia records for each file
                // PostMedia::create([
                //     'post_id' => $post->id,
                //     'filename' => $filename,
                //     'media_type' => $mediaType,
                //     'file_path' => 'posts/' . $filename
                // ]);
            }
        }

        return response()->json([
            'success' => true,
            'post' => [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'content' => $post->content,
                'media' => $post->media,
                'media_type' => $post->media_type,
                'media_url' => $post->media ? asset('posts/' . $post->media) : null,
                'all_media' => $mediaFiles, // All uploaded media files
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ]
        ]);
    }
}
