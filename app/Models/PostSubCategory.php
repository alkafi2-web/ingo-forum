<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSubCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function category() {
        return $this->belongsTo(PostCategory::class);
    }
}
