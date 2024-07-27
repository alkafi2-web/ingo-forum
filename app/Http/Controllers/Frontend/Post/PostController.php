<?php

namespace App\Http\Controllers\Frontend\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request, $categorySlug)
    {
        // Fetch the post category with its posts and subcategories
        $postCategory = PostCategory::where('slug', $categorySlug)
                        ->with(['posts','subcategories'])
                        ->firstOrFail(); // Assuming the category slug is unique

        // Separate the paginated posts collection from the category object
        $posts = $postCategory->posts()->Where('posts.status', 1)->paginate(9);

        return view('frontend.post.index', compact('postCategory', 'posts'));
    }

    /**
     * Display a single post with comments, latest posts, and related posts.
     *
     * @param  string  $categorySlug
     * @param  string  $postSlug
     * @return \Illuminate\View\View
     */
    public function showSinglePost($categorySlug, $postSlug)
    {
        $post = Post::where('status', 1)
                    ->where('slug', $postSlug)
                    ->whereHas('category', function ($query) use ($categorySlug) {
                        $query->where('slug', $categorySlug);
                    })
                    ->with('category', 'comments', 'comments.replies') // Eager load comments and their replies
                    ->firstOrFail();

        $latestPosts = Post::where('status', 1)
                            ->where('category_id', $post->category_id)
                            ->where('id', '<>', $post->id) // Exclude the current post
                            ->latest()
                            ->take(5)
                            ->get();

        $relatedPosts = Post::where('status', 1)
                            ->where('category_id', $post->category_id)
                            ->where('id', '<>', $post->id) // Exclude the current post
                            ->inRandomOrder() // Example of random order for related posts
                            ->take(5)
                            ->get();

        return view('frontend.post.single-post', compact('post', 'latestPosts', 'relatedPosts'));
    }

    public function storeComment(Request $request)
    {
        if (!Auth::guard('member')->check()) {
            return response()->json([
                'success' => false,
                'msg' => 'Be a member to write comment',
            ]);
        }
        // Get authenticated user using the 'member' guard
        $user = Auth::guard('member')->user();
        
        $request->validate([
            'post_id' => 'required|exists:posts,id', // Validate post_id exists in posts table    
            'comment_text' => 'required|string',
        ]);

        // Create new comment
        $comment = new Comment();
        $comment->post_id = $request->post_id; // Adjust as per your form structure
        $comment->member_id = $user->id;
        $comment->comment_text = $request->comment_text;
        $comment->save();

        return response()->json(['success' => true]);
    }

    public function storeReply(Request $request)
    {
        // if (!Auth::guard('member')->check()) {
        //     return response()->json([
        //         'success' => false,
        //         'msg' => 'Be a member to write reply',
        //     ]);
        // }

        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'reply_text' => 'required',
        ]);
        
        // Get authenticated user using the 'member' guard
        $user = Auth::guard('member')->user();
        

        // Create new reply
        $reply = new Reply();
        $reply->comment_id = $request->comment_id;
        $reply->member_id = $user->id;
        $reply->reply_text = $request->reply_text;
        $reply->save();

        return response()->json(['success' => true]);
    }

    public function storeReaction(Request $request)
    {
        // Get authenticated user using the 'member' guard
        $user = Auth::guard('member')->user();
        
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        // Check if reaction exists, toggle it if so, or create new
        $existingReaction = Reaction::where('comment_id', $request->comment_id)
                                    ->where('member_id', $user->id)
                                    ->first();

        if ($existingReaction) {
            $existingReaction->delete();
        } else {
            $reaction = new Reaction();
            $reaction->comment_id = $request->comment_id;
            $reaction->member_id = $user->id;
            $reaction->save();
        }

        return response()->json(['success' => true]);
    }
    
    public function deleteCommentOrReply(Request $request)
    {
        if ($request->has('comment_id')) {
            Comment::where('id', $request->comment_id)->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Comment has been deleted'
            ]);
        }
        if ($request->has('reply_id')) {
            Reply::where('id', $request->reply_id)->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Reply has been deleted'
            ]);
        }
    }

}
