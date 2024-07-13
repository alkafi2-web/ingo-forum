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
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by'); // Assuming 'added_by' is the foreign key in your posts table
    }
}
