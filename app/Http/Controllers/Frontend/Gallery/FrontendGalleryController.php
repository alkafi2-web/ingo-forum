<?php

namespace App\Http\Controllers\Frontend\Gallery;

use App\Http\Controllers\Controller;
use App\Models\MediaAlbum;
use Illuminate\Http\Request;

class FrontendGalleryController extends Controller
{
    public function photoGallery()
    {
        return $albums = MediaAlbum::with([
            'mediaGalleries' => function ($query) {
                $query->where('status', 1);
            },
            'addedBy' // Include the user relationship
        ])->where('status', 1)->paginate(9);
        return view('frontend.gallery.photos');
    }
}
