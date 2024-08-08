<?php

namespace App\Http\Controllers\Frontend\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\MemberInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the latest 12 events and paginate them
        $events = Event::with('participants.member', 'creator')->where('status', 1)->latest()->paginate(12);
        return view('frontend.event.event', compact('events'));
    }

    public function show($slug)
    {
        $event = Event::with('creator')->where('slug', $slug)->where('status', 1)->firstOrFail();
        if ($event) {
            return view('frontend.event.details', compact('event'));
        } else {
            abort(404);
        }
    }

    public function memberEventIndex(Request $request)
    {
        // $member = Auth::guard('member')->user()->load('memberInfos');
        return view('frontend.member.dashboard.partials.event.event-index');
    }

    public function joinEvent(Request $request)
    {
        // Define the validation rules
        $rules = [
            'attendee_name' => 'required|string|max:255',
            'attendee_email' => 'required|email|max:255',
            'attendee_phone' => 'required|string|max:15',
            'have_guest' => 'required|in:yes,no',
            'are_you_member' => 'required|in:yes,no',
        ];

        // If the user has a guest, validate the guest fields
        if ($request->have_guest === 'yes') {
            $rules['guest_name.*'] = 'required|string|max:255';
            $rules['guest_email.*'] = 'required|email|max:255';
            $rules['guest_phone.*'] = 'required|string|max:15';
        }

        // If the user is a member, validate the membership ID
        if ($request->are_you_member === 'yes') {
            $rules['membership_id'] = 'required|string|max:20';
        }

        // Validate the request input
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // If the user is a member, validate the membership ID
        if ($request->are_you_member === 'yes') {
            $memberFound = MemberInfo::where('membership_id', request('membership_id'))->first();
            if ($memberFound) {
                $member_id = $memberFound->member_id;
            } else {
                // Return success response
                return response()->json([
                    'success' => false,
                    'msg' => "Membership ID doesn't exist",
                ]);
            }
        }
        // Prepare guest information as JSON
        $guestInfo = [];
        if ($request->have_guest === 'yes') {
            foreach ($request->guest_name as $index => $name) {
                $guestInfo[] = [
                    'name' => $name,
                    'email' => $request->guest_email[$index],
                    'phone' => $request->guest_phone[$index],
                ];
            }
        }

        // Calculate total participants
        $totalParticipants = 1 + count($guestInfo); // Default attendee + guests

        // Prepare data for insertion
        $registrationData = [
            'event_id' => $request->event_id,
            'member_id' => $member_id,
            'attendee_name' => $request->attendee_name,
            'attendee_email' => $request->attendee_email,
            'attendee_phone' => $request->attendee_phone,
            'guest_info' => !empty($guestInfo) ? json_encode($guestInfo) : null,
            'total_participant' => $totalParticipants,
            'reg_fees' => 0, // Assuming reg_fees is set to 0 by default
            'reg_fees_status' => 1, // Assuming reg_fees_status is set to 1 by default
        ];

        // Create the event registration
        $registration = EventRegistration::create($registrationData);

        // Return success response
        return response()->json([
            'success' => true,
            'msg' => "Join form has been submitted",
        ]);
    }


    public function memberEventList(Request $request)
    {
        $events = Event::where('creator_type','\App\Models\Member')->where('creator_id',Auth::guard('member')->id())->latest();
        if ($request->ajax()) {

            return DataTables::of($events)
                ->make(true);
        }
        return view('frontend.member.dashboard.partials.event.event-index');
    }
}
