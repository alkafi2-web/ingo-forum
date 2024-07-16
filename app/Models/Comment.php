<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = ['post_id', 'member_id', 'comment_text'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }
}
