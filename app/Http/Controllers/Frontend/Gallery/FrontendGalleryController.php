<?php

namespace App\Http\Controllers\Frontend\Gallery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendGalleryController extends Controller
{
    public function photoGallery()
    {
        return view('frontend.gallery.photos');
    }
}
