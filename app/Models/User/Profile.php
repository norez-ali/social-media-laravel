<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'profile_photo',
        'cover_photo',
        'gender',
        'location',
        'username',
        'education',
        'work',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
