<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class FrontAuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('member')->check()) {
            // User is authenticated, redirect to homepage
            return redirect('/');
        }
        session()->put('keep_return_url', url()->previous());
        return view('frontend.auth.login');

        // User is not authenticated, show the login page
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

            $previousUrl = session('keep_return_url');
            $redirectUrl = route('member.dashboard');

            return response()->json([
                'success' => true,
                'message' => 'Login Successfull',
                'redirect' => $redirectUrl,
            ], 200);
        } else {
            // Authentication failed
            return response()->json(['errors' => ['login_email' => [trans('auth.failed')]]], 422);
        }
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

    public function profileDownload($membership_id)
    {
        $memberinfo = MemberInfo::where('membership_id', $membership_id)->with('member')->first();
        $profileAttachment = $memberinfo->profile_attachment;
        $dir = public_path('/frontend/images/member/');
        $extension = pathinfo($dir . $profileAttachment, PATHINFO_EXTENSION);

        $profile_attachment_path = $dir . $profileAttachment;

        if (file_exists($profile_attachment_path)) {
            return response()->download($profile_attachment_path, $membership_id . '.' . $extension);
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }
}
