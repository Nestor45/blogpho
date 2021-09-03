<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        // return $this->belongsToMany(Comment::class);
        return $this->belongsToMany(User::class, 'comments', 'post_id', 'user_id');
    }

    public function likes()
    {
        // return $this->belongsToMany(Like::class);
        return $this->belongsToMany(User::class, 'like_post_user', 'post_id', 'user_id');
    }
}
