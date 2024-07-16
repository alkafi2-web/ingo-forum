<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Check if the authenticated user has reacted to this comment.
     *
     * @return bool
     */
    public function userHasReacted()
    {
        $user = Auth::guard('member')->user(); // Assuming 'member' guard is used

        if (!$user) {
            return false; // Return false if user is not authenticated
        }

        // Check if there exists a reaction by the authenticated user for this comment
        return $this->reactions()->where('member_id', $user->id)->exists();
    }
}
