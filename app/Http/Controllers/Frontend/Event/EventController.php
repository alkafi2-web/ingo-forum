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

    public function show($date)
    {
        $events = Event::whereDate('start_date', '<=', $date)
                       ->whereDate('end_date', '>=', $date)
                       ->get();
        return response()->json(['events' => $events]);
    }

    public function memberEventIndex(Request $request)
    {
        // $member = Auth::guard('member')->user()->load('memberInfos');
        return view('frontend.member.dashboard.partials.event.event-index');
    }
}
