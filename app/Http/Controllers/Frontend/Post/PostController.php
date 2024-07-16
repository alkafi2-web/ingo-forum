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

    /**
     * Display a single post with comments, latest posts, and related posts.
     *
     * @param  string  $categorySlug
     * @param  string  $postSlug
     * @return \Illuminate\View\View
     */
    public function showSinglePost($categorySlug, $postSlug)
    {
        $post = Post::where('slug', $postSlug)
                    ->whereHas('category', function ($query) use ($categorySlug) {
                        $query->where('slug', $categorySlug);
                    })
                    ->with('category', 'comments', 'comments.replies') // Eager load comments and their replies
                    ->firstOrFail();

        $latestPosts = Post::where('category_id', $post->category_id)
                            ->where('id', '<>', $post->id) // Exclude the current post
                            ->latest()
                            ->take(5)
                            ->get();

        $relatedPosts = Post::where('category_id', $post->category_id)
                            ->where('id', '<>', $post->id) // Exclude the current post
                            ->inRandomOrder() // Example of random order for related posts
                            ->take(5)
                            ->get();

        return view('frontend.post.single-post', compact('post', 'latestPosts', 'relatedPosts'));
    }

    /**
     * Store a new comment for a post.
     *
     * @param  CommentRequest  $request
     * @param  int  $postId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeComment(CommentRequest $request, $postId)
    {
        $post = Post::findOrFail($postId);

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->member_id = auth()->id(); // Assuming authenticated member
        $comment->comment_text = $request->input('comment_text');
        $comment->save();

        return back()->with('success', 'Comment posted successfully.');
    }

    /**
     * Store a new reply for a comment.
     *
     * @param  CommentRequest  $request
     * @param  int  $commentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReply(CommentRequest $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        $reply = new Reply();
        $reply->comment_id = $comment->id;
        $reply->member_id = auth()->id(); // Assuming authenticated member
        $reply->reply_text = $request->input('comment_text');
        $reply->save();

        return back()->with('success', 'Reply posted successfully.');
    }

    /**
     * Store a reaction to a comment or reply.
     *
     * @param  Request  $request
     * @param  string  $type  'comment' or 'reply'
     * @param  int  $id  Comment or reply ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeReaction(Request $request, $type, $id)
    {
        $model = ($type === 'comment') ? Comment::findOrFail($id) : Reply::findOrFail($id);

        $reaction = Reaction::where('model_type', get_class($model))
                            ->where('model_id', $model->id)
                            ->where('member_id', auth()->id())
                            ->first();

        if ($reaction) {
            // Update existing reaction
            $reaction->reaction_type = $request->input('reaction_type');
            $reaction->save();
        } else {
            // Create new reaction
            $reaction = new Reaction();
            $reaction->model_type = get_class($model);
            $reaction->model_id = $model->id;
            $reaction->member_id = auth()->id();
            $reaction->reaction_type = $request->input('reaction_type');
            $reaction->save();
        }

        return response()->json(['success' => true]);
    }
}
