<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'media'   => 'nullable|mimetypes:image/*,video/*|max:51200',
        ]);

        $user = Auth::user();

        $mediaType = 'none';
        $mediaPath = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');

            // Detect if it's image or video
            if (str_starts_with($file->getMimeType(), 'image')) {
                $mediaType = 'image';
            } elseif (str_starts_with($file->getMimeType(), 'video')) {
                $mediaType = 'video';
            }

            // Store in storage/app/public/stories
            $mediaPath = $file->store('stories', 'public');
        } else {
            $mediaType = 'none';
        }

        // Save in DB (example)
        $story = $user->stories()->create([
            'user_id' => $user->id,
            'content'    => $validated['content'] ?? null,
            'media'      => $mediaPath,
            'media_type' => $mediaType,
        ]);

        // Return response (for immediate frontend display)
        return response()->json([
            'success'    => true,
            'story'      => $story,
            'media_url'  => $mediaPath ? asset('storage/' . $mediaPath) : null,
        ]);
    }
}
