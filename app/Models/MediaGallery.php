<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaGallery extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function mediaAlbum()
    {
        return $this->belongsTo(MediaAlbum::class, 'album_id');
    }
}
