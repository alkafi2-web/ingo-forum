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
use App\Models\PostRead;
use Illuminate\Support\Str;
// seo 
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class PostController extends Controller
{
    

    public function index(Request $request, $categorySlug)
    {
        // Fetch the post category with its posts and subcategories
        $postCategory = PostCategory::where('slug', $categorySlug)
            ->with(['posts', 'subcategories'])
            ->firstOrFail(); // Assuming the category slug is unique

        // Build the query for filtering posts
        $query = $postCategory->posts()->where('posts.status', 1);

        // Apply filters if present
        // if ($request->input('search')) {
        //     $query->where('title', 'like', '%' . $request->input('search') . '%');
        // }
        if ($request->input('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('long_des', 'like', "%{$searchTerm}%")
                  ;
            });
        }
        if ($request->input('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Get the paginated results
        $posts = $query->paginate(9);

        // Fetch categories for the filter dropdown
        $categories = PostCategory::all();

        // Return partial view for AJAX request
        if ($request->ajax()) {
            $html = view('frontend.post.partials.post', compact('posts', 'postCategory'))->render();
            $pagination = view('frontend.post.partials.pagination', compact('posts'))->render();
            return response()->json(['html' => $html, 'pagination' => $pagination]);
        }

        return view('frontend.post.index', compact('postCategory', 'posts', 'categories'));
    }



    /**
     * Display a single post with comments, latest posts, and related posts.
     *
     * @param  string  $categorySlug
     * @param  string  $postSlug
     * @return \Illuminate\View\View
     */
    public function showSinglePost(Request $request, $categorySlug, $postSlug)
    {
        $post = Post::where('status', 1)
            ->where('slug', $postSlug)
            ->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            })
            ->with('category', 'comments', 'comments.replies', 'totalRead') // Eager load comments and their replies
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

        // Track the read
        $ipAddress = $request->ip();
        PostRead::firstOrCreate(
            ['post_id' => $post->id, 'ip_address' => $ipAddress]
        );

        // Get the total reads for this post
        $readCount = $post->totalRead->count();

        // Generate keywords from the description
        $description = Str::limit(htmlspecialchars_decode(strip_tags($post->long_des)), 500);
        $keywords = $this->generateKeywords($description);

        // Set SEO meta tags
        SEOMeta::setTitle($post->title);
        SEOMeta::setDescription(Str::limit(htmlspecialchars_decode(strip_tags($post->long_des)), 200));
        SEOMeta::addMeta('article:published_time', $post->created_at->toW3CString(), 'property');
        SEOMeta::addKeyword($keywords);

        OpenGraph::setDescription(Str::limit(htmlspecialchars_decode(strip_tags($post->long_des)), 200));
        OpenGraph::setTitle($post->title);
        OpenGraph::setUrl(route('single.post', ['categorySlug' => $categorySlug, 'postSlug' => $postSlug]));
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addImage(asset("public/frontend/images/posts/{$post->banner}"));

        TwitterCard::setTitle($post->title);
        TwitterCard::setSite('@your_twitter_handle');
        TwitterCard::setDescription(Str::limit(htmlspecialchars_decode(strip_tags($post->long_des)), 200));
        TwitterCard::setImage(asset("public/frontend/images/posts/{$post->banner}"));

        JsonLd::setTitle($post->title);
        JsonLd::setDescription(Str::limit(htmlspecialchars_decode(strip_tags($post->long_des)), 200));
        JsonLd::setType('Article');
        JsonLd::addImage(asset("public/frontend/images/posts/{$post->banner}"));

        return view('frontend.post.single-post', compact('post', 'latestPosts', 'relatedPosts', 'readCount'));
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
        if (!Auth::guard('member')->check()) {
            return response()->json([
                'success' => false,
                'msg' => 'Be a member to reply comment',
            ]);
        }
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
        if (!Auth::guard('member')->check()) {
            return response()->json([
                'success' => false,
                'msg' => 'Be a member to react comment',
            ]);
        }
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

        return response()->json([
            'success' => true,
            'msg' => 'Reaction has been added'
        ]);
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

    private function generateKeywords($text)
    {
        // Define a list of common stop words
        $stopWords = [
            'i',
            'me',
            'my',
            'myself',
            'we',
            'our',
            'ours',
            'ourselves',
            'you',
            'your',
            'yours',
            'yourself',
            'yourselves',
            'he',
            'him',
            'his',
            'himself',
            'she',
            'her',
            'hers',
            'herself',
            'it',
            'its',
            'itself',
            'they',
            'them',
            'their',
            'theirs',
            'themselves',
            'what',
            'which',
            'who',
            'whom',
            'this',
            'that',
            'these',
            'those',
            'am',
            'is',
            'are',
            'was',
            'were',
            'be',
            'been',
            'being',
            'have',
            'has',
            'had',
            'having',
            'do',
            'does',
            'did',
            'doing',
            'a',
            'an',
            'the',
            'and',
            'but',
            'if',
            'or',
            'because',
            'as',
            'until',
            'while',
            'of',
            'at',
            'by',
            'for',
            'with',
            'about',
            'against',
            'between',
            'into',
            'through',
            'during',
            'before',
            'after',
            'above',
            'below',
            'to',
            'from',
            'up',
            'down',
            'in',
            'out',
            'on',
            'off',
            'over',
            'under',
            'again',
            'further',
            'then',
            'once',
            'here',
            'there',
            'when',
            'where',
            'why',
            'how',
            'all',
            'any',
            'both',
            'each',
            'few',
            'more',
            'most',
            'other',
            'some',
            'such',
            'no',
            'nor',
            'not',
            'only',
            'own',
            'same',
            'so',
            'than',
            'too',
            'very',
            's',
            't',
            'can',
            'will',
            'just',
            'don',
            'should',
            'now'
        ];

        // Convert the description to lowercase and split into words
        $words = explode(' ', strtolower($text));

        // Filter out the stop words
        $keywords = array_diff($words, $stopWords);

        // Return the first 10 keywords
        return array_slice($keywords, 0, 10);
    }

    public function memberPostIndex(Request $request)
    {
        return view('frontend.member.dashboard.partials.blog.blog-index');
    }



}
