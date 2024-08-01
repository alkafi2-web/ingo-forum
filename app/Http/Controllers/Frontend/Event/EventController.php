<?php

namespace App\Http\Controllers\Frontend\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {
        return view('frontend.event.event');
    }

    public function show($date)
    {
        $events = Event::whereDate('start_date', '<=', $date)
                       ->whereDate('end_date', '>=', $date)
                       ->get();
        return response()->json(['events' => $events]);
    }
}
