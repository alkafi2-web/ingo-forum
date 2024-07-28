<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Member;


class DashboardController extends Controller
{
    public function dashboard()
    {
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

        return view('admin.dashboard.dashborad', compact('latestPosts', 'latestMembers'));
    }
}
