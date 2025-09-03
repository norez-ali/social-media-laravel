<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'media',
        'media_type',
        'visibility',
        'featured',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
