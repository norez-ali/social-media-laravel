<?php

namespace App\Models\User\Group;

use App\Models\User;
use App\Models\User\Group\GroupPost;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'privacy',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_user')
            ->withPivot('role')
            ->withTimestamps();
    }
    public function posts()
    {
        return $this->hasMany(GroupPost::class);
    }
}
