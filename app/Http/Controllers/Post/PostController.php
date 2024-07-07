<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    public function category(Request $request)
    {
        if ($request->ajax()) {
            $categoryies = PostCategory::latest();;

            return DataTables::of($categoryies)
                ->make(true);
        }
        return view('admin.post.category.index');
    }

    public function categoryCreate(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:post_categories,name',
        ], [
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a string.',
            'name.max' => 'The category name may not be greater than 255 characters.',
            'name.unique' => 'The category name has already been taken.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        // Create a new category with slug
        $category = new PostCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->status = 1;
        $category->save();
        return response()->json(['success' => ['success' => 'Category saved successfully!']]);
    }

    public function categoryDelete(Request $request)
    {
        $category = PostCategory::findOrFail($request->id);
        // Delete the banner record
        $category->delete();

        return response()->json(['success' => 'Post category deleted successfully']);
    }

    public function categoryStatus(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        $category = PostCategory::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $category->status = $newStatus;

        // Save the changes to the database
        $category->save();

        return response()->json(['success' => 'Post Category status updated successfully']);
    }

    public function categoryEdit(Request $request)
    {
        $category = PostCategory::findOrFail($request->id);

        return response()->json(['category' => $category]);
    }

    public function categoryUpdate(Request $request)
    {
        // Find the category by ID
        $category = PostCategory::find($request->id);

        if (!$category) {
            return response()->json(['success' => false, 'errors' => ['Category not found']], 404);
        }

        // Validate the form data, ensuring unique name except for the current category
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:post_categories,name,' . $category->id,
        ], [
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a string.',
            'name.max' => 'The category name may not be greater than 255 characters.',
            'name.unique' => 'The category name has already been taken.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        // Update the category with new data
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->save();
        
        return response()->json(['success' => ['success' => 'Post category updated successfully']]);
    }
}
