<?php

namespace App\Models\User;

use App\Models\User;
use App\Models\User\Story;
use Illuminate\Database\Eloquent\Model;

class StoryComment extends Model
{
    protected $fillable = [
        'user_id',
        'story_id',
        'comment',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function story()
    {
        return $this->belongsTo(story::class);
    }
}
