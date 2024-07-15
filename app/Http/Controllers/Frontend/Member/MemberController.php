<?php

namespace App\Http\Controllers\Frontend\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function becomeMember()
    {
        return view('frontend.member.become-member');
    }

    public function memberRegister(Request $request)
    {
        // Define validation rules
        $rules = [
            'org_name' => 'required|string|max:255',
            'org_website' => 'required|string|max:255',
            'org_email' => 'required|email|max:255',
            'org_type' => ['required', Rule::in(['1', '2'])],
            'org_address' => 'required|string|max:255',
            'director_name' => 'required|string|max:255',
            'director_email' => 'required|email|max:255',
            'director_phone' => 'required|string|max:20',
            'login_email' => 'required|email|max:255',
            'login_phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ];

        // Define custom error messages
        $messages = [
            'org_name.required' => 'The organisation name is required.',
            'org_website.required' => 'The organisation website is required.',
            'org_email.required' => 'The organisation email is required.',
            'org_email.email' => 'The organisation email must be a valid email address.',
            'org_type.required' => 'The organisation type is required.',
            'org_type.in' => 'The selected organisation type is invalid.',
            'org_address.required' => 'The organisation address is required.',
            'director_name.required' => 'The director name is required.',
            'director_email.required' => 'The director email is required.',
            'director_email.email' => 'The director email must be a valid email address.',
            'director_phone.required' => 'The director phone is required.',
            'login_email.required' => 'The login email is required.',
            'login_email.email' => 'The login email must be a valid email address.',
            'password.required' => 'The password is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
        $member = Member::create([
            'email' => $request->login_email,
            'phone' => $request->login_phone,
            'password' => Hash::make($request->input('password')),
        ]);
        return $member->id;
        return $request->all();
    }
}
