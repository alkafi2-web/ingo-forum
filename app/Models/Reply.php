<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    
    protected $fillable = ['comment_id', 'member_id', 'reply_text'];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
