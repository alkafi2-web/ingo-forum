<?php

namespace App\Http\Controllers\Frontend\Publication;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\PublicationCategory;
use Illuminate\Http\Request;

class FrontnedPublicationController extends Controller
{
    public function index()
    {
        $categories = PublicationCategory::where('status',1)->get();
        $authorsAndPublishers = Publication::select('author', 'publisher')->distinct()->get();
        $publications = Publication::with('addedBy','category')->where('status',1)->latest()->paginate(9);
        return view('frontend.publication.publication',compact('publications','categories','authorsAndPublishers'));
    }
}
