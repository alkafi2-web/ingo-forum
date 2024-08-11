<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileNgo extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function category()
    {
        return $this->belongsTo(FileCategory::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(FileCategory::class, 'subcategory_id');
    }

    public function creator()
    {
        return $this->morphTo();
    }
}
