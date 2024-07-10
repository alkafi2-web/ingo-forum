<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use App\Models\PostSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    public function subcategory(Request $request)
    {
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
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:post_categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (PostSubCategory::where('name', $value)->exists() || PostCategory::where('name', $value)->exists()) {
                        $fail('The subcategory name must be unique and not exist in the categories.');
                    }
                }
            ],
        ], [
            'category.required' => 'The category field is required.',
            'category.exists' => 'The selected category does not exist.',
            'name.required' => 'The subcategory name is required.',
            'name.string' => 'The subcategory name must be a string.',
            'name.max' => 'The subcategory name must not be greater than 255 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        PostSubCategory::create([
            'category_id' => $request->category,
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);
        return response()->json(['success' => ['success' => 'Sub Category saved successfully!']]);
    }

    public function subcategoryDelete(Request $request)
    {
        $subcategory = PostSubCategory::findOrFail($request->id);
        // Delete the banner record
        $subcategory->delete();

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
        
    }
}
