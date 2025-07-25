<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Mail\MailException;

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

        $memberInfo = MemberInfo::where('id', $member->id)->first();

        // Send the reset link via email
        try {
            Mail::send('frontend.auth.passwords.reset-email', [
                'token' => $token,
                'organisationName' => $memberInfo->organisation_name
            ], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password Notification');
            });

            // If mail was sent successfully
            return back()->with('success', 'We have emailed your password reset link!');
        } catch (MailException $e) {
            // If an error occurred while sending the mail
            return back()->with('error', 'Failed to send password reset email');
        } catch (\Exception $e) {
            // Catch other exceptions
            return back()->with('error', 'Failed to send password reset email');
        }
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

        return redirect()->route('frontend.login')->with('success', 'Your password has been reset!');
    }
}
