<?php

namespace App\Http\Controllers\Frontend\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function becomeMember()
    {
        return view('frontend.member.become-member');
    }
}
