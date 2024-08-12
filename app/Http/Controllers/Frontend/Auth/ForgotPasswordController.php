<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('frontend.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:members,email',
        ]);

        $token = Str::random(64);
        $member = Member::where('email', $request->email)->first();

        // Update the reset token and its creation time
        $member->rp_token = $token;
        $member->rp_token_created_at = Carbon::now();
        $member->save();

        // Send the reset link via email
        Mail::send('frontend.auth.passwords.reset-email', ['token' => $token], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function showResetForm($token)
    {
        return view('frontend.auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:members,email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required',
        ]);

        $member = Member::where('email', $request->email)
            ->where('rp_token', $request->token)
            ->first();

        if (!$member || Carbon::parse($member->rp_token_created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['token' => 'This password reset token is invalid or has expired.']);
        }

        $member->password = Hash::make($request->password);
        $member->rp_token = null;
        $member->rp_token_created_at = null;
        $member->save();

        return redirect()->route('frontend.login')->with('status', 'Your password has been reset!');
    }
}
