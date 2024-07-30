<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(PostSubCategory::class, 'sub_category_id', 'id');
    }
    

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by'); // Assuming 'added_by' is the foreign key in your posts table
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function totalRead()
    {
        return $this->hasMany(PostRead::class);
    }

    public function replies()
    {
        return $this->hasManyThrough(Reply::class, Comment::class, 'post_id', 'comment_id', 'id', 'id');
    }
}
