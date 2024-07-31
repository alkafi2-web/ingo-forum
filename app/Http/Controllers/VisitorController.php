<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function track(Request $request)
    {
        $ipAddress = $request->ip();
        $agent = new Agent();

        $device = $agent->device();
        $browser = $agent->browser();

        $visitor = Visitor::firstOrCreate(
            ['ip_address' => $ipAddress, 'visit_date' => Carbon::today()->toDateString()],
            ['device' => $device, 'browser' => $browser, 'is_new_visitor' => true]
        );

        if (!$visitor->wasRecentlyCreated) {
            $visitor->is_new_visitor = false;
        }

        $visitor->save();

        return response()->json(['success' => 'Visitor tracked successfully']);
    }

    public function stats()
    {
        $totalVisitors = Visitor::count();
        $todayVisitors = Visitor::whereDate('created_at', today())->count();
        $newVisitors = Visitor::where('is_new_visitor', true)->count();
        $uniqueVisitors = Visitor::distinct('ip_address')->count();

        return response()->json([
            'total_visitors' => $totalVisitors,
            'today_visitors' => $todayVisitors,
            'new_visitors' => $newVisitors,
            'unique_visitors' => $uniqueVisitors,
        ]);
    }
}
