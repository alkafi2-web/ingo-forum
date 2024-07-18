<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FrontAuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            // User is authenticated, redirect to homepage
            return redirect('/');
        }

        // User is not authenticated, show the login page
        return view('frontend.auth.login');
    }
    public function loginPost(Request $request)
    {
        // Define validation rules
        $rules = [
            'login_email' => 'required|email',
            'password' => 'required|string|min:6',
        ];

        // Create the validator
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
        // Attempt to log the user in
        if (Auth::guard('member')->attempt(['email' => $request->login_email, 'password' => $request->password])) {
            // Authentication was successful, now check the status
            $member = Auth::guard('member')->user();
            if (in_array($member->status, [0, 2, 3])) {
                // Log the member out
                Auth::guard('member')->logout();
                return response()->json(['errors' => ['login_email' => ['Your account is not allowed to log in.']]], 403);
            }
            return response()->json(['success' => true, 'message' => 'Successfully Be A Member.Now Log in And Update Info', 'redirect' => route('frontend.index')], 200);
        } else {
            // Authentication failed
            return response()->json(['errors' => ['login_email' => [trans('auth.failed')]]], 422);
        }

        return $request->all();
    }

    public function oursMember()
    {
        $membersInfos = MemberInfo::with('member')
            ->whereHas('member', function ($query) {
                $query->where('status', 1);
            })
            ->select('member_id', 'membership_id', 'logo')
            ->get();
        return view('frontend.member.our-members', compact('membersInfos'));
    }

    public function profileShow($membershipId)
    {
        $memberinfo = MemberInfo::where('membership_id', $membershipId)->with('member')->first();
        return view('frontend.member.member-profile', compact('memberinfo'));
    }
}
