<?php

namespace App\Models\User;

use App\Models\User;
use App\Models\User\StoryComment;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'media',
        'media_type',
        'view',
        'expires_at',

    ];
    protected $casts = [
        'expires_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function storyComments()
    {
        return $this->hasMany(StoryComment::class);
    }
}
