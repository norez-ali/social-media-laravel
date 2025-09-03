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
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'content'   => 'nullable|string|max:1000',
            'media.*'   => 'nullable|mimes:jpg,jpeg,png,gif,bmp,svg,webp,mp4,mov,avi,mkv,webm,wmv,flv,mpeg|max:10240',
            'visibility' => 'nullable|string',
            'featured'  => 'nullable|boolean',
        ]);

        $mediaData = [];

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $index => $file) {
                $extension  = strtolower($file->getClientOriginalExtension());
                $mediaType  = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']) ? 'image' : 'video';
                $filename   = time() . '_' . uniqid() . '.' . $extension;
                $filePath   = $file->storeAs('posts', $filename, 'public');

                $mediaData[] = [
                    'filename'   => $filename,
                    'file_path'  => Storage::url($filePath),
                    'media_type' => $mediaType,
                ];
            }
        }

        $post = Post::create([
            'user_id'    => $user->id,
            'content'    => $request->input('content'),
            'media'      => $mediaData,
            'media_type' => $mediaData[0]['media_type'] ?? null,
            'visibility' => $request->input('visibility', 'public'),
            'featured'   => $request->boolean('featured', false),
        ]);

        return response()->json([
            'success' => true,
            'post'    => $post,
        ]);
    }
}
