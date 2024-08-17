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
use App\Models\Visitor;

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

        $today = Carbon::today();

        // Get visitor statistics
        $totalVisitors = Visitor::count();
        $todayVisitors = Visitor::whereDate('created_at', today())->count();
        $uniqueVisitors = Visitor::distinct('ip_address')->count();
        $newVisitors = Visitor::where('is_new_visitor', true)->count();

        $visitorsData = $this->getVisitorsData('week');

        // ecent char 
        $eventStatusCounts = Event::selectRaw('
            CASE 
            WHEN approval_status = 1 THEN "1"
            WHEN approval_status = 0 THEN "0"
            WHEN approval_status = 2 THEN "2"
            WHEN approval_status = 3 THEN "3"
            WHEN approval_status IS NULL THEN "1"
            END as approval_status_label, 
                        count(*) as count
                    ')
            ->groupBy('approval_status_label')
            ->pluck('count', 'approval_status_label')
            ->toArray();
       $postStatusCounts = Post::selectRaw('
            CASE 
            WHEN approval_status = "1" THEN "1"
            WHEN approval_status = "0" THEN "0"
            WHEN approval_status = "2" THEN "2"
            WHEN approval_status = "3" THEN "3"
            WHEN approval_status IS NULL THEN "1"
                            END as status_label, 
                            count(*) as count
                        ')
            ->groupBy('status_label')
            ->pluck('count', 'status_label')
            ->toArray();
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
            'latestActivities',
            'visitorsData',
            'totalVisitors',
            'todayVisitors',
            'uniqueVisitors',
            'newVisitors',
            'eventStatusCounts',
            'postStatusCounts'
        ));
    }
    public function filterVisitors(Request $request)
    {
        $timeFrame = $request->get('timeFrame', 'week');
        $visitorsData = $this->getVisitorsData($timeFrame);

        return response()->json($visitorsData);
    }

    private function getVisitorsData($timeFrame)
    {
        $query = Visitor::query();

        switch ($timeFrame) {
            case 'year':
                $query->selectRaw('YEAR(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date', 'asc');
                break;
            case 'month':
                $query->selectRaw('MONTH(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date', 'asc');
                break;
            case 'week':
            default:
                $query->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->where('created_at', '>=', Carbon::now()->subWeek())
                    ->groupBy('date')
                    ->orderBy('date', 'asc');
                break;
        }

        return $query->get()->map(function ($item) use ($timeFrame) {
            switch ($timeFrame) {
                case 'year':
                    $item->date = Carbon::createFromFormat('Y', $item->date)->format('Y');
                    break;
                case 'month':
                    $item->date = Carbon::createFromFormat('m', $item->date)->format('F');
                    break;
                case 'week':
                default:
                    $item->date = Carbon::parse($item->date)->format('Y-m-d');
                    break;
            }

            return [
                'date' => $item->date,
                'count' => $item->count,
            ];
        });
    }
}
