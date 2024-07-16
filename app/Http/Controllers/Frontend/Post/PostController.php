<?php

namespace App\Http\Controllers\Frontend\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request, $categorySlug)
    {
        // Fetch the post category with its posts and subcategories
        $postCategory = PostCategory::where('slug', $categorySlug)
                        ->with(['posts','subcategories'])
                        ->firstOrFail(); // Assuming the category slug is unique

        // Separate the paginated posts collection from the category object
        $posts = $postCategory->posts()->paginate(9);

        return view('frontend.post.index', compact('postCategory', 'posts'));
    }

    public function showSinglePost($categorySlug, $postSlug)
    {
        // Fetch the post category with its posts and subcategories
        $postCategory = PostCategory::where('slug', $categorySlug)
                        ->with(['posts','subcategories'])
                        ->firstOrFail(); // Assuming the category slug is unique
        
        // Fetch the single post based on the category and post slugs
        $post = Post::where('slug', $postSlug)
                    ->where('category_id', $postCategory->id)
                    ->with('category', 'addedBy')
                    ->firstOrFail();

        // Fetch latest posts from the same category except the current post
        $latestPosts = Post::where('category_id', $postCategory->id)
                        ->where('id', '!=', $post->id)
                        ->latest()
                        ->limit(5)
                        ->get();

        // Fetch related posts based on some criteria (could be based on tags, keywords, etc.)
        // For now, let's assume related posts are also the latest posts
        $relatedPosts = Post::where('category_id', $postCategory->id)
                        ->where('id', '!=', $post->id)
                        ->latest()
                        ->limit(5)
                        ->get();

        return view('frontend.post.single-post', compact('postCategory', 'post', 'latestPosts', 'relatedPosts'));
    }

    // Method to store comment
    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'comment_text' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->comment_text = $request->comment_text;
        $comment->post_id = $postId;
        $comment->member_id = Auth::guard('member')->id(); // Using Member model
        $comment->save();

        return back()->with('success', 'Comment added successfully.');
    }

    // Method to store reply
    public function storeReply(Request $request, $commentId)
    {
        $request->validate([
            'reply_text' => 'required|string',
        ]);

        $reply = new Reply();
        $reply->reply_text = $request->reply_text;
        $reply->comment_id = $commentId;
        $reply->member_id = Auth::guard('member')->id(); // Using Member model
        $reply->save();

        return back()->with('success', 'Reply added successfully.');
    }

    // Method to store reaction
    public function reactToComment($commentId)
    {
        $reaction = new Reaction();
        $reaction->comment_id = $commentId;
        $reaction->member_id = Auth::guard('member')->id(); // Using Member model
        $reaction->save();

        return back()->with('success', 'Reacted to comment successfully.');
    }
}
