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
use App\Helpers\Helper;
// seo 
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

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
        $event = Event::with('creator')->where('slug', $slug);

        if ((Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasPermissionTo('event-view')) || (Auth::guard('member')->check() && Auth::guard('member')->user()->id == $event->first()->creator_id && $event->first()->creator_type == "\App\Models\Member")) {
            $event = $event->firstOrFail();
        }
        else{
            $event = $event->where('status', 1)->firstOrFail();
        }
        
        // Generate keywords from the description
        $description = Str::limit(htmlspecialchars_decode(strip_tags($event->details)), 500);
        $keywords = Helper::generateKeywords($description);

        // Set SEO meta tags
        SEOMeta::setTitle($event->title);
        SEOMeta::setDescription(Str::limit(htmlspecialchars_decode(strip_tags($event->details)), 200));
        SEOMeta::addMeta('article:published_time', $event->created_at->toW3CString(), 'property');
        SEOMeta::addKeyword($keywords);

        OpenGraph::setDescription(Str::limit(htmlspecialchars_decode(strip_tags($event->details)), 200));
        OpenGraph::setTitle($event->title);
        OpenGraph::setUrl(route('frontend.event.show', $event->slug));
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addImage(asset("public/frontend/images/events"."/".($event->media??"frontend/images/placeholder.jpg")));

        TwitterCard::setTitle($event->title);
        TwitterCard::setSite('@your_twitter_handle');
        TwitterCard::setDescription(Str::limit(htmlspecialchars_decode(strip_tags($event->details)), 200));
        TwitterCard::setImage(asset("public/frontend/images/events"."/".$event->media??"frontend/images/placeholder.jpg"));

        JsonLd::setTitle($event->title);
        JsonLd::setDescription(Str::limit(htmlspecialchars_decode(strip_tags($event->details)), 200));
        JsonLd::setType('Article');
        JsonLd::addImage(asset("public/frontend/images/events"."/".$event->media??"frontend/images/placeholder.jpg"));

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
        else{
            $member_id = null;
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
        $events = Event::where('creator_type','\App\Models\Member')->where('creator_id',Auth::guard('member')->id())->latest()->get();
        if ($request->ajax()) {
            return DataTables::of($events)
                ->make(true);
        }
        return view('frontend.member.dashboard.partials.event.event-index');
    }

    public function memberEventJoinList(Request $request)
    {
        $event_attendees = EventRegistration::where('member_id',Auth::guard('member')->id())->with('event', 'member')->latest();
        if ($request->ajax()) {
            return DataTables::of($event_attendees)
                ->addColumn('event_name', function ($event) {
                    return $event->event->title;
                })
                ->addColumn('attendee_type', function ($event) {
                    return $event->member_id == null ? 'Guest' : 'Member';
                })
                ->addColumn('guest_info', function ($event) {
                    // Decode the attendee_guest JSON to an array if it's stored as a JSON string
                    $guests = is_string($event->guest_info) ? json_decode($event->guest_info, true) : $event->attendee_guest;
        
                    if (!empty($guests) && is_array($guests)) {
                        $guestInfo = '';
                        foreach ($guests as $guest) {
                            $guestInfo .= 'Name: ' . $guest['name'] . "<br>";
                            $guestInfo .= 'Email: ' . $guest['email'] . "<br>";
                            $guestInfo .= 'Phone: ' . $guest['phone'] . "<br><br>";
                        }
                        return $guestInfo;
                    }
                    return 'NO Guest Attendee';
                })
                ->rawColumns(['guest_info'])
                ->make(true);
        }
    }
}
