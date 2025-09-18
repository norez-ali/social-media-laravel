<?php

namespace App\Models;

use App\Models\User\Comment;
use App\Models\User\Post;
use App\Models\User\PostLike;
use App\Models\User\Profile;
use App\Models\User\Story;
use App\Models\User\StoryComment;
use App\Models\User\Friendship;
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

    // Friend requests sent by the user
    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }

    // Friend requests received by the user
    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }
    // Actual friends (accepted)
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'sender_id', 'receiver_id')
            ->wherePivot('status', 'accepted')
            ->withTimestamps();
    }
    //for suggestions on the home page
    public function scopeSuggestions($query, $authId)
    {
        $friendIds = Friendship::where(function ($q) use ($authId) {
            $q->where('sender_id', $authId)
                ->orWhere('receiver_id', $authId);
        })
            ->get(['sender_id', 'receiver_id'])   // get both columns
            ->flatMap(function ($row) {
                return [$row->sender_id, $row->receiver_id];
            })
            ->unique()
            ->toArray();

        $friendIds[] = $authId; // exclude self

        return $query->whereNotIn('id', $friendIds);
    }

    //these are to fetch the friends list of logged in user
    // Friendships where I sent the request
    public function friendsOfMine()
    {
        return $this->belongsToMany(User::class, 'friendships', 'sender_id', 'receiver_id')
            ->wherePivot('status', 'accepted')
            ->with('profile');
    }

    // Friendships where I received the request
    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friendships', 'receiver_id', 'sender_id')
            ->wherePivot('status', 'accepted')
            ->with('profile');
    }

    // Merge both to get all friends
    public function getFriendsAttribute()
    {
        return $this->friendsOfMine->merge($this->friendOf);
    }




    protected static function booted(): void
    {
        //for creating a null profile
        static::created(function ($user) {
            $user->profile()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
