<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\Friendship;
use App\Models\User\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index($id)
    {
        $user = User::with([
            'profile',
            'posts' => function ($query) {
                $query->withCount(['likes', 'comments']) // ✅ counts both likes and comments
                    ->with(['likes.user', 'comments.user']); // eager load likes + comments users
            }
        ])->find($id);
        $checkFriend = Friendship::where(function ($q) use ($id) {
            $q->where('sender_id', auth_user()->id)
                ->where('receiver_id', $id);
        })
            ->orWhere(function ($q) use ($id) {
                $q->where('sender_id', $id)
                    ->where('receiver_id', auth_user()->id);
            })
            ->first(); // returns null if no friendship


        $friends = $user->friends;     // ✅ full friends list (both sides)



        return view('user.profile.index', get_defined_vars());
    }
    public function updateProfile(Request $request)
    {
        $user = auth_user();

        $validated = $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cover_photo'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gender'        => 'nullable|string|max:20',
            'location'      => 'nullable|string|max:100',
            'username'      => 'nullable|string|max:50|unique:user_profiles,username,' . ($user->profile->id ?? 'null'),
            'education'     => 'nullable|string|max:100',
            'work'          => 'nullable|string|max:100',
            'bio'           => 'nullable|string|max:500',
        ]);

        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        // Handle profile photo
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($profile->profile_photo && Storage::disk('public')->exists('profile_photos/' . $profile->profile_photo)) {
                Storage::disk('public')->delete('profile_photos/' . $profile->profile_photo);
            }

            // Store new profile photo
            $profilePhoto = $request->file('profile_photo');
            $profilePhotoName = time() . '_profile_' . uniqid() . '.' . $profilePhoto->getClientOriginalExtension();
            $profilePhoto->storeAs('profile_photos', $profilePhotoName, 'public');
            $validated['profile_photo'] = $profilePhotoName;
        } else {
            unset($validated['profile_photo']);
        }

        // Handle cover photo
        if ($request->hasFile('cover_photo')) {
            // Delete old cover photo if exists
            if ($profile->cover_photo && Storage::disk('public')->exists('cover_photos/' . $profile->cover_photo)) {
                Storage::disk('public')->delete('cover_photos/' . $profile->cover_photo);
            }

            // Store new cover photo
            $coverPhoto = $request->file('cover_photo');
            $coverPhotoName = time() . '_cover_' . uniqid() . '.' . $coverPhoto->getClientOriginalExtension();
            $coverPhoto->storeAs('cover_photos', $coverPhotoName, 'public');
            $validated['cover_photo'] = $coverPhotoName;
        } else {
            unset($validated['cover_photo']);
        }

        // Create or Update profile
        $profile->fill($validated);
        $profile->user_id = $user->id;
        $profile->save();

        return response()->json([
            'profile_photo' => $profile->profile_photo ? asset('storage/profile_photos/' . $profile->profile_photo) : null,
            'cover_photo' => $profile->cover_photo ? asset('storage/cover_photos/' . $profile->cover_photo) : null,
            'gender'        => $profile->gender,
            'location'      => $profile->location,
            'username'      => $profile->username,
            'education'     => $profile->education,
            'work'          => $profile->work,
            'bio'           => $profile->bio,
        ]);
    }
    public function photos()
    {

        $user = User::with(['profile', 'posts' => function ($query) {
            $query->where('media_type', 'image');
        }])->find(Auth::id());

        return view('user.profile.nav.photos', get_defined_vars());
    }
}
