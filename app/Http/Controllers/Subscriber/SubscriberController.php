<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Subsciber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SubscriberController extends Controller
{
    public function newslaterSubscribe(Request $request)
    {
        $messages = [
            'email.required' => 'Email is required',
            'email.email' => 'Please provide a valid email address',
            'email.max' => 'Email should not be more than 255 characters',
            'email.unique' => 'This email is already subscribed',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:subscibers,email',
        ], $messages);

        if ($validator->fails()) {
            // Return a JSON response with validation errors
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Store the validated email in the database
        $subscriber = new Subsciber(); // Assuming your model name is Subscriber
        $subscriber->email = $request->input('email');
        $subscriber->status = 1;
        $subscriber->save();

        return response()->json(['success' => ['success' => 'You have successfully subscribed to INGO Forum']]);
    }

    public function subscriberlist(Request $request)
    {
        // if (!Auth::guard('admin')->user()->hasPermissionTo('contact-list-view')) {
        //     abort(401);
        // }
        if ($request->ajax()) {
            $subscriberList = Subsciber::latest();

            return DataTables::of($subscriberList)
                ->make(true);
        }
        return view('admin.subscriber.subscriber-list');
    }
}
