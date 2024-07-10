<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaAlbum extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function mediaGalleries()
    {
        return $this->hasMany(MediaGallery::class, 'album_id');
    }
    
}
