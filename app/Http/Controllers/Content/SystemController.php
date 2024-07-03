<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\MainContent;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function index()
    {
        return view('admin.content.systemt-content.index');
    }
    public function systemPost(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'short_content' => 'required|string',
            'facebook' => ['nullable', 'string', 'url'],
            'linkedin' => ['nullable', 'string', 'url'],
            'youtube' => ['nullable', 'string', 'url'],
            'twitter' => ['nullable', 'string', 'url'],
            'logo' => ['nullable', 'file', 'mimes:png,jpeg,gif', 'max:1024'], // max:1024 specifies 1MB limit (1024 KB)
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'short_content.required' => 'The short content field is required.',
            'short_content.string' => 'The short content must be a string.',
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


        // Data to update or insert
        $data = [
            'name' => $validatedData['name'],
            'short_content' => $validatedData['short_content'],
            'facebook' => $validatedData['facebook'],
            'linkedin' => $validatedData['linkedin'],
            'youtube' => $validatedData['youtube'],
            'twitter' => $validatedData['twitter'],
        ];

        // Handle logo update if provided
        if (isset($validatedData['logo'])) {
            return $data['logo'] = $validatedData['logo']; // Example storage path
            
        }

        // Update or insert based on conditions
        foreach ($data as $key => $value) {
            MainContent::updateOrCreate(
                ['name' => $key],
                ['content' => $value]
            );
        }


        return $request->all();
    }
}
