<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterSubscriptionMail;
use App\Models\Subsciber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

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
            'email' => 'required|string|email|max:255|unique:subscibers,email', // Corrected table name
        ], $messages);

        if ($validator->fails()) {
            // Return a JSON response with validation errors
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Generate a unique token
        do {
            $token = Str::random(64);
        } while (Subsciber::where('subscription_token', $token)->exists()); // Corrected model name

        // Store the validated email in the database
        $subscriber = new Subsciber(); // Corrected model name
        $subscriber->email = $request->input('email');
        $subscriber->subscription_token = $token;
        $subscriber->status = 1;
        $subscriber->save();

        // Check if SMTP settings are configured before sending email
        if (config('mail.mailers.smtp.username') && config('mail.mailers.smtp.password')) {
            try {
                // Send a subscription confirmation email
                Mail::to($subscriber->email)->send(new NewsletterSubscriptionMail($subscriber));

                // Return a success response if the email is sent successfully
                return response()->json([
                    'success' => true,
                    'type' => 'success',
                    'message' => 'You have successfully subscribed to INGO Forum also ther confimation email sent',
                ]);
            } catch (\Exception $e) {
                // Return a success response but with an email error message
                return response()->json([
                    'success' => true,
                    'type' => 'warning',
                    'message' => 'Subscription successful, but the confirmation email could not be sent.',
                    'mail_error' => $e->getMessage(),
                ]);
            }
        }

        // If SMTP is not configured, return a standard success response
        return response()->json([
            'success' => true,
            'type' => 'success',
            'message' => 'You have successfully subscribed to INGO Forum also ther confimation email sent',
        ]);
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
    public function unsubscribe($token)
    {
        // Check if the subscriber exists
        $subscriber = Subsciber::where('subscription_token', $token)->first();

        if ($subscriber) {
            // Update the status from 1 (subscribed) to 0 (unsubscribed)
            $subscriber->status = 0;
            $subscriber->save();

            return redirect()->route('frontend.index')->with([
                'success' => 'You have successfully unsubscribed from the INGO Forum newsletter.',
            ]);
        } else {
            // If the email is not found
            return redirect()->route('frontend.index')->with([
                'success' => 'The email address is not found in our subscriber list.',
            ]);
        }
    }
}
