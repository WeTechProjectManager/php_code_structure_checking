<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded =['id'];
    use HasFactory;

    public function getPostUser(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function number_of_like(){
        return $this->hasMany(PostReact::class, 'post_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getPostCommentAll(){
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }
}
