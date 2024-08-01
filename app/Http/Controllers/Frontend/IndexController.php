<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use App\Models\Faqs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function index()
    {
        return view('frontend.index');
        // return view('frontend.page.static.static-layout');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function contactInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        ContactInfo::create($validatedData);

        return response()->json(['success' => ['Contact information sumbit successfully']], 200);
        return $request->all();
    }
    public function faqs()
    {
        $faqs = Faqs::where('status', 1)->get();
        return view('frontend.faqs.faqs', compact('faqs'));
    }

    public function aboutUs()
    {
        return view('frontend.page.static.about-us');
    }
    public function whyIngo()
    {
        return view('frontend.page.static.why-ingo-forum');
    }
    public function executiveCommittee()
    {
        return view('frontend.page.static.executive-committee');
    }
    public function memberCriteria()
    {
        return view('frontend.page.static.membership-criteria');
    }

    public function newslaterSubscribe(Request $request)
    {
        // Custom validation messages
        $messages = [
            'email.required' => 'Email is Required',
            
        ];

        // Create a validator instance with custom messages
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
        ], $messages);
        return $request->all();
    }
}
