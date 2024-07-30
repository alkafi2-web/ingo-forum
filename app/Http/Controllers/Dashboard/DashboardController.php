<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Member;
use App\Models\ContactInfo;
use App\Models\Event; 
use App\Models\User;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (!Auth::guard('admin')->user()->hasPermissionTo('dashboard-view')) {
            abort(401);
        }
        // Fetch the latest 6 posts
        $latestPosts = Post::with(['category', 'subcategory', 'addedBy', 'comments', 'replies', 'totalRead'])
        ->where('status', 1)
        ->latest()
        ->limit(6)
        ->get();
    
        foreach ($latestPosts as $post) {
            // Summing up the counts of comments and replies
            $post->total_comments_and_replies = $post->comments->count() + $post->replies->count();
            $post->total_reads = $post->totalRead->count();
        }
        // Fetch the latest 6 active members
        $latestMembers = Member::with('info')
            ->where('status', 1)
            ->latest()
            ->limit(6)
            ->get();

        // Count total members, active members, and member requests
        $totalMembers = Member::count();
        $activeMembers = Member::where('status', 1)->count();
        $memberRequests = Member::where('status', 0)->count();

        // Count contact requests
        $totalContactRequests = ContactInfo::count();
        $todayContactRequests = ContactInfo::whereDate('created_at', Carbon::today())->count();
        $currentMonthContactRequests = ContactInfo::whereMonth('created_at', Carbon::now()->month)->count();

        // Fetch the latest 5 events
        $latestEvents = Event::where('status', 1)
            ->latest()
            ->limit(5)
            ->get();

        // Count active and online users
        $activeUsers = User::where('status', 1)->count();
        $onlineUsers = User::where('status', 1)
            ->whereNotNull('last_activity')
            ->where('last_activity', '>', Carbon::now()->subMinutes(5))
            ->count();
  
        // Fetch the latest activities
        $latestActivities = Activity::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard.dashborad', compact(
            'latestPosts', 
            'latestMembers', 
            'totalMembers', 
            'activeMembers', 
            'memberRequests', 
            'totalContactRequests',
            'todayContactRequests', 
            'currentMonthContactRequests',
            'latestEvents', 
            'activeUsers', 
            'onlineUsers', 
            'latestActivities'
        ));
    }
}
