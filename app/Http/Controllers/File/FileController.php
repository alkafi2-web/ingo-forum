<?php

namespace App\Http\Controllers\File;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\FileCategory;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FileController extends Controller
{
    // category start
    public function category(Request $request)
    {
        if ($request->ajax()) {
            $categoryies = FileCategory::latest();;

            return DataTables::of($categoryies)
                ->make(true);
        }
        return view('admin.file.category.index');
    }
    public function categoryCreate(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:file_categories,name',
        ], [
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a string.',
            'name.max' => 'The category name may not be greater than 255 characters.',
            'name.unique' => 'The category name has already been taken.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
        $slug = Str::slug($request->name, '-');
        // Create a new category with slug
        $category = new FileCategory();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->parent_id = 0;
        $category->status = 1;
        $category->save();

        Helper::log("Create file category $category->name");
        return response()->json(['success' => ['success' => 'File Category saved successfully!']]);
    }

    public function categoryDelete(Request $request)
    {
        $category = FileCategory::findOrFail($request->id);
        // Delete the banner record
        $category->delete();
        Helper::log("Delete file category $category->name");
        return response()->json(['success' => 'File category deleted successfully']);
    }

    public function categoryStatus(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        $category = FileCategory::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $category->status = $newStatus;

        // Save the changes to the database
        $category->save();
        $statusMessage = $newStatus == 0
            ? "$category->name category deactive"
            : "$category->name category active";
        Helper::log($statusMessage);
        return response()->json(['success' => 'Post Category status updated successfully']);
    }

    public function categoryEdit(Request $request)
    {
        $category = FileCategory::findOrFail($request->id);

        return response()->json(['category' => $category]);
    }

    public function categoryUpdate(Request $request)
    {
        // Find the category by ID
        $category = FileCategory::find($request->id);

        if (!$category) {
            return response()->json(['success' => false, 'errors' => ['Category not found']], 404);
        }

        // Validate the form data, ensuring unique name except for the current category
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:file_categories,name,' . $category->id,
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
        Helper::log("Update file category $category->name");
        return response()->json(['success' => ['success' => 'File category updated successfully']]);
    }

    // category end

    // sub category start
    public function subcategory(Request $request)
    {
        // if (!Auth::guard('admin')->user()->hasPermissionTo('post-subcategory-manage')) {
        //     abort(401);
        // }
        if ($request->ajax()) {
            $subcategories = FileCategory::where('parent_id', '!=', 0)->latest()->get();

            return DataTables::of($subcategories)
                ->addColumn('category_name', function ($subcategory) {
                    return $subcategory->category->name ?? 'N/A';
                })
                ->make(true);
        }
        $categories = FileCategory::where('parent_id', 0)->get();
        return view('admin.file.sub-category.index', [
            'categories' => $categories,
        ]);
    }
    public function subcategoryCreate(Request $request)
    {
        // return $request->all();
        $categoryId = $request->input('category');
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:file_categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
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
        $subcategory = FileCategory::create([
            'parent_id' => $request->category,
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'status' => 1,
        ]);
        Helper::log("Create file subcategory $subcategory->name");
        return response()->json(['success' => ['success' => 'File Subcategory saved successfully!']]);
    }

    public function subcategoryDelete(Request $request)
    {
        $subcategory = FileCategory::findOrFail($request->id);
        // Delete the banner record
        $subcategory->delete();
        Helper::log("Delete file subcategory $subcategory->name");
        return response()->json(['success' => 'Post sub category deleted successfully']);
    }

    public function subcategoryStatus(Request $request)
    {
        $subcategory = FileCategory::findOrFail($request->id);

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
        $subcategory = FileCategory::findOrFail($request->id);

        return response()->json(['subcategory' => $subcategory]);
    }

    public function subcategoryUpdate(Request $request)
    {
        
        // Find the subcategory by ID or throw an exception if not found
        $subcategory = FileCategory::findOrFail($request->id);

        // Retrieve the category ID from the request
        $categoryId = $request->input('category');

        // Validate the input data
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:post_categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
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
        $subcategory->parent_id = $request->category;
        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name, '-');
        $subcategory->save();
        // Log the update action
        Helper::log("Updated file subcategory $subcategory->name");
        // Return a JSON response indicating success
        return response()->json(['success' => ['success' => 'File Sub Category saved successfully!']]);
    }
    // sub category end
}
