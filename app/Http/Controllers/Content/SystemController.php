<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\MainContent;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SystemController extends Controller
{
    public function index()
    {

        return view('admin.content.systemt-content.index');
    }
    public function systemPost(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'short_content' => 'required|string',
            'email' => 'nullable|string|email', // Added email validation
            'phone' => 'nullable|string', // Added phone validation (adjust as per your validation rules)
            'address' => 'nullable|string', // Added phone validation (adjust as per your validation rules)
            'facebook' => ['nullable', 'string', 'url'],
            'linkedin' => ['nullable', 'string', 'url'],
            'youtube' => ['nullable', 'string', 'url'],
            'twitter' => ['nullable', 'string', 'url'],
            'logo' => ['nullable', 'file', 'mimes:png,jpeg,gif', 'max:1024'], // max:1024 specifies 1MB limit
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'short_content.required' => 'The short content field is required.',
            'short_content.string' => 'The short content must be a string.',
            'address.string' => 'Address must be a string.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'phone.string' => 'The phone must be a string.', // Adjust as per specific phone validation rules
            'facebook.string' => 'The facebook must be a string.',
            'facebook.url' => 'The facebook must be a valid URL.',
            'linkedin.string' => 'The linkedin must be a string.',
            'linkedin.url' => 'The linkedin must be a valid URL.',
            'youtube.string' => 'The youtube must be a string.',
            'youtube.url' => 'The youtube must be a valid URL.',
            'twitter.string' => 'The twitter must be a string.',
            'twitter.url' => 'The twitter must be a valid URL.',
            'logo.file' => 'The logo must be a file.',
            'logo.mimes' => 'The logo must be a PNG, JPEG, or GIF image.',
            'logo.max' => 'The logo may not be greater than 1MB in size.',
        ]);


        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Data to update or insert
        $data = [
            'name' => $request->input('name'),
            'short_content' => $request->input('short_content'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'facebook' => $request->input('facebook'),
            'linkedin' => $request->input('linkedin'),
            'youtube' => $request->input('youtube'),
            'twitter' => $request->input('twitter'),
        ];

        // Handle logo update if provided
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $randomNumber = rand(1000, 9999); // You can adjust the range as needed
            $logoName = 'logo' . $randomNumber . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('/frontend/images/'), $logoName);

            // Update MainContent for logo
            MainContent::updateOrCreate(
                ['name' => 'logo'],
                ['content' => $logoName]
            );

            // Add logo name to data array
            $data['logo'] = $logoName;
        }

        // Update or insert based on conditions
        foreach ($data as $key => $value) {
            MainContent::updateOrCreate(
                ['name' => $key],
                ['content' => $value]
            );
        }

        // Redirect back with success message
        return redirect()->route('system')->with('success', 'Successfully updated system information!');
    }
}
