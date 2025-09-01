<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with('profile')->find(Auth::id());

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

        // ✅ Handle profile photo
        if ($request->hasFile('profile_photo')) {
            if ($profile->profile_photo && file_exists(public_path('images/profile_photos/' . $profile->profile_photo))) {
                unlink(public_path('images/profile_photos/' . $profile->profile_photo));
            }

            $image = $request->file('profile_photo');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/profile_photos'), $filename);
            $validated['profile_photo'] = $filename;
        } else {
            unset($validated['profile_photo']);
        }

        // ✅ Handle cover photo
        if ($request->hasFile('cover_photo')) {
            if ($profile->cover_photo && file_exists(public_path('images/cover_photos/' . $profile->cover_photo))) {
                unlink(public_path('images/cover_photos/' . $profile->cover_photo));
            }

            $image = $request->file('cover_photo');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/cover_photos'), $filename);
            $validated['cover_photo'] = $filename;
        } else {
            unset($validated['cover_photo']);
        }

        // ✅ Create or Update
        $profile->fill($validated);
        $profile->user_id = $user->id;  // make sure relation is set
        $profile->save();

        return back()->with('status', 'Profile updated successfully!');
    }
}
