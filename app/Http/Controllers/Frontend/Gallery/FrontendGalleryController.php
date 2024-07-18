<?php

namespace App\Http\Controllers\Frontend\Gallery;

use App\Http\Controllers\Controller;
use App\Models\MediaAlbum;
use App\Models\MediaGallery;
use Illuminate\Http\Request;

class FrontendGalleryController extends Controller
{
    public function photoGallery()
    {
        $albums = MediaAlbum::with([
            'mediaGalleries' => function ($query) {
                $query->where('status', 1);
            },
            'addedBy' // Include the user relationship
        ])->where('status', 1)->paginate(9);
        return view('frontend.gallery.photos', compact('albums'));
    }

    public function singlePhotoGallery($id)
    {
        $album = MediaAlbum::with([
            'mediaGalleries' => function ($query) {
                $query->where('status', 1);
            },
            'addedBy' // Include the user relationship
        ])
            ->where('status', 1)
            ->where('id', $id)->first();
        return view('frontend.gallery.single-photo-gallery', compact('album'));
    }

    public function videoGallery()
    {
        $videos = MediaGallery::with('addedBy')->where('type', 'video')->where('status', 1)->paginate(9);
        return view('frontend.gallery.video',compact('videos'));
    }
}
