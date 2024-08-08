<?php

namespace App\Http\Controllers\Frontend\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the latest 12 events and paginate them
        $events = Event::with('participants.member')->where('status', 1)->latest()->paginate(1);
        return view('frontend.event.event', compact('events'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->where('status', 1)->firstOrFail();
        if ($event) {
            return view('frontend.event.details', compact('event'));
        }
        else{
            abort(404);
        }
    }

    public function memberEventIndex(Request $request)
    {
        // $member = Auth::guard('member')->user()->load('memberInfos');
        return view('frontend.member.dashboard.partials.event.event-index');
    }
}
