<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 
        'description', 
        'image', 
        'background_color', 
        'overlay_color', 
        'title_color', 
        'description_color', 
        'button',
        'status',
        'added_by'
    ];

    protected $casts = [
        'button' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
