<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = ['user_id', 'title', 'content', 'cover_image'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
