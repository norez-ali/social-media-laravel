<?php

namespace App\Models;

use App\Models\User\Comment;
use App\Models\User\Post;
use App\Models\User\PostLike;
use App\Models\User\Profile;
use App\Models\User\Story;
use App\Models\User\StoryComment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'username',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function stories()
    {
        return $this->hasMany(Story::class);
    }
    public function storyComments()
    {
        return $this->hasMany(StoryComment::class);
    }


    protected static function booted(): void
    {
        static::created(function ($user) {
            $user->profile()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
