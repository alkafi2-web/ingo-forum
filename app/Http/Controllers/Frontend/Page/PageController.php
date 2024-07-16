<?php

namespace App\Http\Controllers\Frontend\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function show($slug)
    {
        // Fetch the page by slug
        $page = Page::where('slug', $slug)->where('visibility', 1)->first();

        // Check if page exists and is visible
        if (!$page) {
            abort(404); // Page not found
        }

        return view('frontend.page.static.static-page', compact('page'));
    }

    public function becomeMember()
    {
        return view('frontend.member.become-member');
    }
}
