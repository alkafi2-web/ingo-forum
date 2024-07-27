<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faqs;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('frontend.index');
        // return view('frontend.page.static.static-layout');
    }
    
    public function contact()
    {
        return view('frontend.contact');
    }
    public function faqs()
    {
        $faqs = Faqs::where('status',1)->get();
        return view('frontend.faqs.faqs',compact('faqs'));
    }

    


}
