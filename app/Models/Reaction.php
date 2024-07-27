<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;
    
    protected $fillable = ['comment_id', 'member_id'];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
