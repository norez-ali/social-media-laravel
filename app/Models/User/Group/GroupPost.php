<?php

namespace App\Models\User\Group;

use App\Models\User;
use App\Models\User\Group\Group;
use Illuminate\Database\Eloquent\Model;

class GroupPost extends Model
{
    protected $fillable = ['group_id', 'user_id', 'content', 'media'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for full media URL
    public function getMediaUrlAttribute()
    {
        return $this->media ? asset('storage/' . $this->media) : null;
    }
}
