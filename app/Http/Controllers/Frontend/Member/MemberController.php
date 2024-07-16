<?php

namespace App\Http\Controllers\Frontend\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
            'director_phone' => 'nullable|string|max:20',
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

        MemberInfo::create([
            'member_id' => $member->id,
            'organisation_name' => $request->org_name,
            'organisation_email' => $request->org_email,
            'organisation_type' => $request->org_type,
            'organisation_website' => $request->org_website,
            'organisation_address' => $request->org_address,

            'director_name' => $request->director_name,
            'director_email' => $request->director_email,
            'director_phone' => $request->director_phone,
        ]);
        return response()->json(['success' => true, 'message' => 'Successfully Be A Member.Now Log in And Update Info', 'redirect' => route('frontend.login')], 200);
    }

    public function memberProfile()
    {
        $member = Auth::guard('member')->user()->load('memberInfos');
        return view('frontend.member.profile', compact('member'));
    }

    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('frontend.login');
    }

    public function profileUpdate(Request $request)
    {
        return $request->all();
        // Define validation rules
        $rules = [
            'org_name' => 'required|string|max:255',
            'org_website' => 'required|string|max:255',
            'org_email' => 'required|email|max:255',
            'org_type' => ['required', Rule::in(['1', '2'])],
            'org_address' => 'required|string|max:255',
            'director_name' => 'required|string|max:255',
            'director_email' => 'required|email|max:255',
            'director_phone' => 'nullable|string|max:20',
            'login_email' => 'required|email|max:255',
            'login_phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
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

        // Get the authenticated member
        $member = Auth::guard('member')->user();

        // Update member information
        $member->email = $request->login_email;
        $member->phone = $request->login_phone;
        if ($request->filled('password')) {
            $member->password = Hash::make($request->password);
        }
        $member->save();

        // Update or create member information
        $memberInfo = $member->memberInfos()->firstOrNew();
        $memberInfo->organisation_name = $request->org_name;
        $memberInfo->organisation_email = $request->org_email;
        $memberInfo->organisation_type = $request->org_type;
        $memberInfo->organisation_website = $request->org_website;
        $memberInfo->organisation_address = $request->org_address;
        $memberInfo->director_name = $request->director_name;
        $memberInfo->director_email = $request->director_email;
        $memberInfo->director_phone = $request->director_phone;
        $memberInfo->save();
        return response()->json(['success' => true, 'message' => 'Successfully Update Your Profile'], 200);

        return $request->all();
    }

    public function uploadProfileImage(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size and allowed formats as needed
        ], [
            'profile_image.required' => 'Please select an image to upload.',
            'profile_image.image' => 'The file must be an image.',
            'profile_image.mimes' => 'Only JPEG, PNG, JPG, and GIF images are allowed.',
            'profile_image.max' => 'The image may not be greater than 2048 kilobytes in size.',
        ]);

        // If validation fails, return JSON response with validation errors
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        // Check if the request contains a file named 'profile_image'
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $directory = public_path('frontend/images/member/');

            // Ensure the directory exists; create it if not
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // Resize the image to fit within 244x243 pixels
            $img = Image::make($image)->fit(244, 243);
            $img->save($directory . $imageName);

            // Get the authenticated member
            $member = Auth::guard('member')->user();
            $memberInfo = $member->memberInfos()->firstOrNew();
            // Delete the old profile photo if exists
            if ($memberInfo->logo) {
                $oldImagePath = public_path('frontend/images/member/' . $memberInfo->logo);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            $memberInfo->logo = $imageName;
            $memberInfo->save();

            return response()->json(['success' => true, 'message' => 'Successfully updated your profile photo or logo.'], 200);
        }

        return response()->json(['error' => 'No image uploaded.'], 400);
    }

    public function profileUpdateSummary(Request $request)
    {
        // return $request->all();
        // Define custom error messages
        $messages = [
            'title.required' => 'The title field is required.',
            'sub_title.required' => 'The sub title field is required.',
            'title.max' => 'The title must not exceed :max characters.',
            'sub_title.max' => 'The sub title must not exceed :max characters.',
            // Add more custom messages as needed
        ];

        // Define validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'value' => 'nullable|string',
            'work' => 'nullable|string',
            'history' => 'nullable|string',
            'other_description' => 'nullable|string',
        ], $messages);

        // If validation fails, return JSON response with validation errors
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
        $member = Auth::guard('member')->user();
        $memberInfo = $member->memberInfos()->firstOrNew();
        $memberInfo->update([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'mission' => $request->mission,
            'vision' => $request->vision,
            'value' => $request->value,
            'work' => $request->work,
            'history' => $request->history,
            'other_description' => $request->other_description,
        ]);
        $memberInfo->save();
        // Return success response
        return response()->json(['success' => true, 'message' => 'Data successfully Update.'], 200);
        return $request->all();
    }

    public function profileUpdateSocial(Request $request)
    {
        // return 'a';
        return $request->all();
    }
}
