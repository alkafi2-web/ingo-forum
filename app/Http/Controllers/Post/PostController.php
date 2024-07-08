<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    public function postCreate()
    {
        $categories = PostCategory::where('status', 1)->with('subcategories')->get();
        return view('admin.post.post-create', [
            'categories' => $categories,
        ]);
    }

    public function postStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'category' => 'required', // Example validation rule
            'subcategory' => 'required',
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:posts',
                // Regex pattern to allow only alphanumeric characters and dashes
                'regex:/^[a-zA-Z0-9\-]*$/u',
            ],
            'long_description' => 'required|string',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example file validation
        ], [
            // Custom error messages
            'category.required' => 'Category is required.',
            'subcategory.required' => 'Subcategory is required.',
            'title.required' => 'Title is required.',
            'slug.required' => 'Slug is required.',
            'slug.unique' => 'Slug must be unique.',
            'slug.regex' => 'Slug must only contain letters, numbers, and dashes.',
            'long_description.required' => 'Long description is required.',
            'banner.required' => 'Banner image is required.',
            'banner.image' => 'Banner must be an image file.',
            'banner.mimes' => 'Banner must be a JPEG, PNG, JPG, or GIF image.',
            'banner.max' => 'Banner size should not exceed 2MB.',
        ]);
        // Check validation results
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Validation failed
        }
        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $bannerName = Str::uuid() . '.' . $banner->getClientOriginalExtension();
            $dir = public_path('/frontend/images/posts/');

            // Ensure the directory exists
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            // Move new image to directory
            $banner->move($dir, $bannerName);
        }
        Post::create([
            'category_id' => $request->category,
            'sub_category_id' => $request->subcategory,
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->title, '-'),
            'short_des' => $request->short_description,
            'long_des' => $request->long_description,
            'banner' => $bannerName,
            'added_by' => Auth::user()->id,
        ]);
        return response()->json(['success' => ['success' => 'Post Added Successfully']]);
    }

    public function postList(Request $request)
    {
        return $posts = Post::with('category', 'subcategory', 'addedBy')->get();
        if ($request->ajax()) {
            
            
            // Format data for DataTables
            return DataTables::of($posts)
                ->addColumn('category_name', function ($post) {
                    return $post->category->name;
                })
                ->addColumn('subcategory_name', function ($post) {
                    return $post->subcategory->name;
                })
                ->addColumn('added_by', function ($post) {
                    return $post->addedBy->name;
                })
                ->make(true);
        }
        return view('admin.post.post-list');
    }
}
