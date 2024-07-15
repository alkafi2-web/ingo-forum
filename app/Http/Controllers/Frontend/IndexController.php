<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('frontend.index');
        // return view('frontend.page.static.static-layout');
    }
    public function becomeMember()
    {
        return 'a';
        return view('frontend.member.become-member');
    }
    


}
