<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    // Specify the fillable attributes
    protected $fillable = [
        'name',
        'type',
        'html',
        'css',
        'settings',
        'applicable_on',
    ];

    // Cast JSON columns to arrays
    protected $casts = [
        'html' => 'array',
        'css' => 'array',
        'settings' => 'array',
    ];
}
