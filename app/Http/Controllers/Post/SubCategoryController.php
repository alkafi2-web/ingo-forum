<?php

namespace App\Http\Controllers\Post;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use App\Models\PostSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    public function subcategory(Request $request)
    {
        if (!Auth::guard('admin')->user()->hasPermissionTo('post-subcategory-manage')) {
            abort(401);
        }
        if ($request->ajax()) {
            $subcategories = PostSubCategory::with('category')->latest()->get();

            return DataTables::of($subcategories)
                ->addColumn('category_name', function ($subcategory) {
                    return $subcategory->category->name ?? 'N/A';
                })
                ->make(true);
        }
        $categories = PostCategory::where('status', 1)->get();
        return view('admin.post.sub-category.index', [
            'categories' => $categories,
        ]);
    }

    public function subcategoryCreate(Request $request)
    {
        // return $request->all();
        $categoryId = $request->input('category');
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:post_categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('post_sub_categories', 'name')
                    ->where(function ($query) use ($categoryId) {
                        return $query->where('category_id', $categoryId);
                    }),
            ],
        ], [
            'category.required' => 'The category field is required.',
            'category.exists' => 'The selected category does not exist.',
            'name.required' => 'The subcategory name is required.',
            'name.string' => 'The subcategory name must be a string.',
            'name.max' => 'The subcategory name must not be greater than 255 characters.',
            'name.unique' => 'The subcategory name has already been taken in this category.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $subcategory = PostSubCategory::create([
            'category_id' => $request->category,
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'status' => 1,
        ]);
        Helper::log("Create post subcategory $subcategory->name");
        return response()->json(['success' => ['success' => 'Sub Category saved successfully!']]);
    }

    public function subcategoryDelete(Request $request)
    {
        $subcategory = PostSubCategory::findOrFail($request->id);
        // Delete the banner record
        $subcategory->delete();
        Helper::log("Delete post subcategory $subcategory->name");
        return response()->json(['success' => 'Post sub category deleted successfully']);
    }

    public function subcategoryStatus(Request $request)
    {
        $subcategory = PostSubCategory::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $subcategory->status = $newStatus;

        // Save the changes to the database
        $subcategory->save();

        return response()->json(['success' => 'Post Sub Category status updated successfully']);
    }
    public function subcategoryEdit(Request $request)
    {
        $subcategory = PostSubCategory::findOrFail($request->id);

        return response()->json(['subcategory' => $subcategory]);
    }

    public function subcategoryUpdate(Request $request)
    {
        
        // Find the subcategory by ID or throw an exception if not found
        $subcategory = PostSubCategory::findOrFail($request->id);

        // Retrieve the category ID from the request
        $categoryId = $request->input('category');

        // Validate the input data
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:post_categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('post_sub_categories', 'name')
                    ->ignore($subcategory->id) // Ignore the current subcategory's ID to allow updating the same name
                    ->where(function ($query) use ($categoryId) {
                        return $query->where('category_id', $categoryId);
                    }),
            ],
        ], [
            'category.required' => 'The category field is required.',
            'category.exists' => 'The selected category does not exist.',
            'name.required' => 'The subcategory name is required.',
            'name.string' => 'The subcategory name must be a string.',
            'name.max' => 'The subcategory name must not be greater than 255 characters.',
            'name.unique' => 'The subcategory name has already been taken in this category.',
        ]);

        // If validation fails, return errors in JSON format
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Update the subcategory with new data
        $subcategory->category_id = $request->category;
        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name, '-');
        $subcategory->save();
        // Log the update action
        Helper::log("Updated post subcategory $subcategory->name");
        // Return a JSON response indicating success
        return response()->json(['success' => ['success' => 'Sub Category saved successfully!']]);
    }
}
