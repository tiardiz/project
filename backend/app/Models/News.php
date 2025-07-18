<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'body', 'author', 'image', 'views', 'likes'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
