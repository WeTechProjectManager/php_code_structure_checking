<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $guarded =['id'];

    use HasFactory;

    public function getPostCommentUserName(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getPostComment(){
        return $this->belongsTo(DefaultComment::class, 'defaultcomment_id', 'id');
    }
}
