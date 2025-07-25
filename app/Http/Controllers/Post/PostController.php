<?php

namespace App\Http\Controllers\Post;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberInfo;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostSubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Stevebauman\Purify\Facades\Purify;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function postCreate()
    {
        if (!Auth::guard('admin')->user()->hasPermissionTo('post-add')) {
            abort(401);
        }
        // return $posts = Post::with(['category', 'subcategory','addedBy'])->where('status',1)->latest()->get();
        $categories = PostCategory::where('status', 1)->with('subcategories')->get();
        return view('admin.post.post-create', [
            'categories' => $categories,
        ]);
    }

    public function postStore(Request $request)
    {
        // Define the validation rules with conditional logic for the slug field
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'subcategory' => 'required',
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable', // Make the slug nullable by default
                'string',
                'max:255',
                // 'unique:posts',
                // Add regex pattern if needed
                // 'regex:/^[\p{L}a-zA-Z0-9\-]*$/u',
            ],
            'long_description' => 'required|string',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            // Custom error messages
            'category.required' => 'Category is required.',
            'subcategory.required' => 'Subcategory is required.',
            'title.required' => 'Title is required.',
            'slug.unique' => 'Slug must be unique.',
            'slug.regex' => 'Slug must only contain letters, numbers, and dashes.',
            'long_description.required' => 'Long description is required.',
            'banner.required' => 'Banner image is required.',
            'banner.image' => 'Banner must be an image file.',
            'banner.mimes' => 'Banner must be a JPEG, PNG, JPG, or GIF image.',
            'banner.max' => 'Banner size should not exceed 2MB.',
            'banner.dimensions' => 'Banner must be 800px by 450px.',
        ]);

        // Conditionally require slug if add_type is not 'member'
        $validator->sometimes('slug', 'required', function ($input) {
            return $input->add_type !== 'member';
        });

        // Check validation results
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $bannerName = Str::uuid() . '.' . $banner->getClientOriginalExtension();
            $dir = public_path('/frontend/images/posts/');

            // Ensure the directory exists
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            // Save the banner image
            $img = Image::make($banner);
            $img->save($dir . $bannerName);
        }
        $slug = $request->slug ?? Str::slug($request->title, '-');

        // Function to generate a random string of 5 characters
        function generateRandomString($length = 3)
        {
            return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
        }

        // Loop to find a unique slug
        while (Post::where('slug', $slug)->exists()) {
            $slug = Str::slug($request->title, '-') . '-' . generateRandomString(); // Append random characters to the slug
        }
        // Create the post record
        Post::create([
            'category_id' => $request->category,
            'sub_category_id' => $request->subcategory,
            'title' => $request->title,
            'slug' => $slug, // Generate slug if not provided
            'long_des' => $request->long_description,
            'banner' => $bannerName,
            'added_by' => $request->add_type === 'member' ? null : Auth::guard('admin')->id(),
            'member_id' => $request->add_type === 'member' ? Auth::guard('member')->id() : null,
            'approval_status' => $request->add_type === 'member' ? 0 : null,
        ]);

        Helper::log("{$request->title} post created");

        return response()->json(['success' => ['success' => 'Post Added Successfully']]);
    }


    public function postList(Request $request)
    {
        if (!Auth::guard('admin')->user()->hasPermissionTo('post-view-all')) {
            abort(401);
        }

        $posts = Post::with('category', 'subcategory', 'addedBy', 'addedBy_member')
            ->where(function ($query) {
                $query->where('approval_status', 1)
                    ->orWhere('approval_status', 2)
                    ->orWhereNull('approval_status');
            })
            ->latest();
        if ($request->ajax()) {
            $category = $request->category;
            $subcategory = $request->subcategory;
            $status = $request->status;

            // Apply filters if provided
            if ($category) {
                $posts->where('category_id', $category);
            }

            if ($subcategory) {
                $posts->where('sub_category_id', $subcategory);
            }

            if ($status !== null) {
                $posts->where('status', $status);
            }
            if ($request->user_id) {
                $posts->where('added_by', 1);
            }
            if ($request->member_id) {
                $posts->where('member_id', 1);
            }


            // Format data for DataTables
            return DataTables::of($posts)
                ->addColumn('category_name', function ($post) {
                    return $post->category->name;
                })
                ->addColumn('category_slug', function ($post) {
                    return $post->category->slug;
                })
                ->addColumn('subcategory_name', function ($post) {
                    return $post->subcategory->name;
                })
                ->addColumn('added_by', function ($post) {
                    return $post->addedBy->name ?? $post->addedBy_member->organisation_name ?? null;
                })
                ->make(true);
        }
        $categories = PostCategory::where('status', 1)->with('subcategories')->get();
        $subcategories = PostSubCategory::where('status', 1)->with('category')->get();
        // Fetch addedBy users and addedBy_members for select options
        $addedByUsers = User::whereIn('id', Post::pluck('added_by'))->pluck('name', 'id');

        $addedByMembers = MemberInfo::whereIn('member_id', Post::pluck('member_id'))->pluck('organisation_name', 'id');
        return view('admin.post.post-list', compact('categories', 'subcategories', 'addedByUsers', 'addedByMembers'));
    }

    public function postDelete(Request $request)
    {
        $post = Post::findOrFail($request->id);
        $bannerImagePath = public_path('/frontend/images/posts/') . $post->banner;
        // Delete the image file if it exists
        if (file_exists($bannerImagePath)) {
            unlink($bannerImagePath);
        }

        // Delete the banner record
        $post->delete();
        Helper::log("$post->title post delete");
        return response()->json(['success' => 'Post deleted successfully']);
    }
    public function postComment(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        $post = Post::findOrFail($request->id);
        if ($post->comment_permission  == 0) {
            $post->comment_permission = 1;
            // Save the changes to the database
            $post->save();
            Helper::log("$post->title post comment enabled");
            return response()->json(['success' => 'Post Comment Enable successfully!']);
        } else {
            $post->comment_permission = 0;
            // Save the changes to the database
            $post->save();
            Helper::log("$post->title post comment disabled");
            return response()->json(['success' => 'Post Comment Disable successfully!']);
        }
    }

    public function postStatus(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        $post = Post::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $post->status = $newStatus;

        // Save the changes to the database
        $post->save();
        $statusMessage = $newStatus == 0 ? "Unpublished $post->title post" : "Published $post->title post";
        Helper::log($statusMessage);
        return response()->json(['success' => 'Post status updated successfully']);
    }

    public function postEdit($id)
    {
        $categories = PostCategory::where('status', 1)->with('subcategories')->get();
        $post = Post::with(['category', 'subcategory'])->where('id', $id)->firstOrFail();
        return view('admin.post.post-edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }
    public function memberPostEdit($id)
    {
        $categories = PostCategory::where('status', 1)->with('subcategories')->get();
        return $post = Post::with(['category', 'subcategory'])->where('id', $id)->firstOrFail();
    }


    public function postUpdate(Request $request)
    {
        // Find the post by its ID
        $post = Post::findOrFail($request->id);

        // Validate incoming request data with conditional slug requirement
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'subcategory' => 'required',
            'title' => [
                'required',
                'string',
                'max:255',
                // 'unique:posts,title,' . $post->id, // Ensure title is unique except for the current post
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                // 'unique:posts,slug,' . $post->id, // Ensure slug is unique except for the current post
                'regex:/^[a-zA-Z0-9\-]*$/u', // Regex pattern to allow only alphanumeric characters and dashes
            ],
            'long_description' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            // Custom error messages
            'category.required' => 'Category is required.',
            'subcategory.required' => 'Subcategory is required.',
            'title.required' => 'Title is required.',
            'title.unique' => 'Title must be unique.', // Custom error message for title uniqueness
            'slug.unique' => 'Slug must be unique.',
            'slug.regex' => 'Slug must only contain letters, numbers, and dashes.',
            'long_description.required' => 'Long description is required.',
            'banner.image' => 'Banner must be an image file.',
            'banner.mimes' => 'Banner must be a JPEG, PNG, JPG, or GIF image.',
            'banner.max' => 'Banner size should not exceed 2MB.',
        ]);

        // Conditionally require slug if add_type is not 'member'
        $validator->sometimes('slug', 'required', function ($input) {
            return $input->add_type !== 'member';
        });

        // Check validation results
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Validation failed
        }

        // Handle banner upload and replacement
        $bannerName = $post->banner;
        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $bannerName = Str::uuid() . '.' . $banner->getClientOriginalExtension();
            $dir = public_path('/frontend/images/posts/');

            // Delete the old banner image if it exists
            $bannerImagePath = public_path('/frontend/images/posts/') . $post->banner;
            if (file_exists($bannerImagePath)) {
                unlink($bannerImagePath);
            }

            // Ensure the directory exists
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            // Save the new banner image
            $banner->move($dir, $bannerName);
        }

        // Update post details
        $post->category_id = $request->category;
        $post->sub_category_id = $request->subcategory;
        $post->title = $request->title;

        // Only update the slug if add_type is not 'member'
        if ($request->add_type !== 'member') {
            $post->slug = $request->slug ?? Str::slug($request->title, '-');
        }

        $post->long_des = $request->long_description;
        $post->banner = $bannerName;
        $post->save();

        Helper::log("{$request->title} post updated");

        return response()->json(['success' => ['success' => 'Post Updated Successfully']]);
    }



    public function postRequestList(Request $request)
    {
        if (!Auth::guard('admin')->user()->hasPermissionTo('post-view-all')) {
            abort(401);
        }
        $posts = Post::with('category', 'subcategory', 'addedBy', 'addedBy_member')->where('member_id', '!=', null)->where('approval_status', 0)->latest();
        if ($request->ajax()) {
            $category = $request->category;
            $subcategory = $request->subcategory;
            $status = $request->status;

            // Apply filters if provided
            if ($category) {
                $posts->where('category_id', $category);
            }

            if ($subcategory) {
                $posts->where('sub_category_id', $subcategory);
            }

            if ($status !== null) {
                $posts->where('approval_status', $status);
            }
            if ($request->user_id) {
                $posts->where('added_by', 1);
            }
            if ($request->member_id) {
                $posts->where('member_id', 1);
            }
            // Format data for DataTables
            return DataTables::of($posts)
                ->addColumn('category_name', function ($post) {
                    return $post->category->name;
                })
                ->addColumn('category_slug', function ($post) {
                    return $post->category->slug;
                })
                ->addColumn('subcategory_name', function ($post) {
                    return $post->subcategory->name;
                })
                ->addColumn('added_by', function ($post) {
                    return $post->addedBy->name ?? null;
                })
                ->addColumn('added_by_member', function ($post) {
                    return $post->addedBy_member->organisation_name ?? null;
                })
                ->make(true);
        }
        $categories = PostCategory::where('status', 1)->with('subcategories')->get();
        $subcategories = PostSubCategory::where('status', 1)->with('category')->get();
        $addedByMembers = MemberInfo::whereIn('member_id', Post::pluck('member_id'))->pluck('organisation_name', 'id');
        return view('admin.post.post-request-list', compact('categories', 'subcategories', 'addedByMembers'));
    }

    public function postRequestView(Request $request, $categorySlug, $postSlug)
    {
        $post = Post::with('addedBy_member', 'category', 'subcategory')->where('slug', $postSlug)
            ->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            })
            ->firstOrFail();
        return view('admin.post.post-view', compact('post'));
    }
    public function approved(Request $request)
    {

        // Find the post by the provided ID
        $post = Post::findOrFail($request->id);

        // Update the approved_status to 1
        $post->approval_status = 1;

        // Save the changes
        $post->save();
        $viewHeader = view('admin.post.partials.view-header', compact('post'))->render();
        return response()->json([
            'success' => 'Post Approved successfully',
            'viewHeader' => $viewHeader,
        ]);
    }
    public function reject(Request $request)
    {

        // Find the post by the provided ID
        $post = Post::findOrFail($request->id);

        // Update the approved_status to 1
        $post->approval_status = 3;

        // Save the changes
        $post->save();
        $viewHeader = view('admin.post.partials.view-header', compact('post'))->render();
        return response()->json([
            'success' => 'Post Reject successfully',
            'viewHeader' => $viewHeader,
        ]);
    }
    public function suspended(Request $request)
    {

        // Find the post by the provided ID
        $post = Post::findOrFail($request->id);

        // Update the approved_status to 1
        $post->approval_status = 2;

        // Save the changes
        $post->save();
        $viewHeader = view('admin.post.partials.view-header', compact('post'))->render();
        return response()->json([
            'success' => 'Post Suspend successfully',
            'viewHeader' => $viewHeader,
        ]);
    }
}
