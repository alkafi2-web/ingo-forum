<?php

namespace App\Http\Controllers\Publication;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\PublicationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PublicationController extends Controller
{
    public function category(Request $request)
    {
        if ($request->ajax()) {
            $categoryies = PublicationCategory::latest();;

            return DataTables::of($categoryies)
                ->make(true);
        }
        return view('admin.publication.category.index');
    }

    public function categoryCreate(Request $request)
    {
        // Generate slug from the name
        $slug = Str::slug($request->name, '-');

        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:publication_categories,name',
            'slug' => 'unique:publication_categories,slug', // Add slug uniqueness validation
        ], [
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a string.',
            'name.max' => 'The category name may not be greater than 255 characters.',
            'name.unique' => 'The category name has already been taken.',
            'slug.unique' => 'The category slug has already been taken.', // Custom error message for slug
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        // Create a new category with slug
        $category = new PublicationCategory();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->status = 1;
        $category->save();

        Helper::log("Create post category $category->name");
        return response()->json(['success' => ['success' => 'Category saved successfully!']]);
    }
    public function categoryDelete(Request $request)
    {
        $category = PublicationCategory::findOrFail($request->id);
        // Delete the banner record
        $category->delete();
        Helper::log("Delete publication category $category->name");
        return response()->json(['success' => 'Publication category deleted successfully']);
    }

    public function categoryStatus(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        $category = PublicationCategory::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $category->status = $newStatus;

        // Save the changes to the database
        $category->save();
        $statusMessage = $newStatus == 0
            ? "$category->name publication category deactive"
            : "$category->name publication category active";
        Helper::log($statusMessage);
        return response()->json(['success' => 'Publication Category status updated successfully']);
    }

    public function categoryEdit(Request $request)
    {
        $category = PublicationCategory::findOrFail($request->id);

        return response()->json(['category' => $category]);
    }

    public function categoryUpdate(Request $request)
    {
        // Find the category by ID
        $category = PublicationCategory::find($request->id);

        if (!$category) {
            return response()->json(['success' => false, 'errors' => ['Publication Category not found']], 404);
        }

        // Validate the form data, ensuring unique name except for the current category
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:publication_categories,name,' . $category->id,
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
        Helper::log("Update publication category $category->name");
        return response()->json(['success' => ['success' => 'Publication category updated successfully']]);
    }
}
