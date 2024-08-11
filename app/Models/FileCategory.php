<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(FileCategory::class, 'parent_id');
    }
    public function subcategories()
    {
        return $this->hasMany(FileCategory::class, 'parent_id');
    }
}
