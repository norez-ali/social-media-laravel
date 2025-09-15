<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User\StoryComment;
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
        }

        // ✅ Only save if content or media exists
        if (!empty($validated['content']) || $mediaPath) {
            $story = $user->stories()->create([
                'user_id'    => $user->id,
                'content'    => $validated['content'] ?? null,
                'media'      => $mediaPath,
                'media_type' => $mediaType,
                'expires_at' => now()->addDay(),
            ]);

            return response()->json([
                'success'    => true,
                'story'      => $story,
                'media_url'  => $mediaPath ? asset('storage/' . $mediaPath) : null,
            ]);
        }

        // ✅ If no content & no media, return error
        return response()->json([
            'success' => false,
            'message' => 'Story must have either content or media.',
        ], 422);
    }

    public function getUserStories($id)
    {
        $user = User::with(['stories' => function ($query) {
            $query->where('expires_at', '>', now());
        }])->findOrFail($id);

        return response()->json([
            'user_id' => $user->id,
            'stories' => $user->stories
        ]);
    }
    public function addStoryComments(Request $request, $storyId)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:2000'
        ]);

        $story_comment = StoryComment::create([
            'comment' => $request->content,
            'user_id' => auth()->user()->id,
            'story_id' => $storyId,
        ]);

        return response()->json([
            'success' => true,
            'comment' => $story_comment,
        ]);
    }
}
