<?php

namespace App\Http\Controllers\Publication;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\PublicationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

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

    // publicatiuon start
    public function publicationCreate()
    {
        // return $posts = Post::with(['category', 'subcategory','addedBy'])->where('status',1)->latest()->get();
        $categories = PublicationCategory::where('status', 1)->get();
        return view('admin.publication.publication-add', [
            'categories' => $categories,
        ]);
    }

    public function publicationStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:publication_categories,id|integer',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'short_description' => 'required|string',
            'file' => 'required|file|mimes:pdf,docx,ppt',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'publish_date' => 'required|date',
        ], [
            'category.exists' => 'The selected category does not exist.',
            'category.integer' => 'The category must be a valid integer.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'author.string' => 'The author must be a string.',
            'author.max' => 'The author may not be greater than 255 characters.',
            'publisher.string' => 'The publisher must be a string.',
            'publisher.max' => 'The publisher may not be greater than 255 characters.',
            'short_description.string' => 'The short description must be a string.',
            'file.file' => 'The file must be a valid file.',
            'file.mimes' => 'The file must be a type of: pdf, docx, ppt.',
            'file.max' => 'The file may not be greater than 2MB.',
            'image.image' => 'The image must be an image.',
            'image.mimes' => 'The image must be a type of: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than 2MB.',
            'publish_date.required' => 'The publish date is required.',
            'publish_date.date' => 'The publish date must be a valid date.',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Validation failed
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $dir = public_path('/frontend/images/publication/');

            // Ensure the directory exists
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $img = Image::make($image);
            $img->save($dir . $imageName);
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $dir = public_path('/frontend/images/publication/');

            // Ensure the directory exists
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $file->move($dir, $fileName);
        }

        $publication = Publication::create([
            'category_id' => $request->input('category'),
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'publish_date' => $request->input('publish_date'),
            'publisher' => $request->input('publisher'),
            'short_description' => $request->input('short_description'),
            'file' => $fileName ?? null,
            'image' => $imageName ?? null,
            'added_by' => Auth::guard('admin')->id(),
        ]);
        Helper::log("$publication->title publication create");
        return response()->json(['success' => ['success' => 'Publication Added Successfully']]);
        // return $request->all();
    }

    public function publicationList(Request $request)
    {
        if ($request->ajax()) {
            $publication = Publication::with('addedBy', 'category')->latest();
            // Format data for DataTables
            return DataTables::of($publication)
                ->addColumn('category_name', function ($publication) {
                    return $publication->category->name;
                })
                ->addColumn('added_by', function ($publication) {
                    return $publication->addedBy->name;
                })
                ->make(true);
        }
        return view('admin.publication.publication-list');
    }

    public function publicationDelete(Request $request)
    {
        $publication = Publication::findOrFail($request->id);
        $ImagePath = public_path('/frontend/images/publication/') . $publication->image;
        // Delete the image file if it exists
        if (file_exists($ImagePath)) {
            unlink($ImagePath);
        }
        $filePath = public_path('/frontend/images/publication/') . $publication->file;
        // Delete the image file if it exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the banner record
        $publication->delete();
        Helper::log("$publication->title publication delete");
        return response()->json(['success' => 'Publication deleted successfully']);
    }

    public function publicationStatus(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        $publication = Publication::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $publication->status = $newStatus;

        // Save the changes to the database
        $publication->save();
        $statusMessage = $newStatus == 0 ? "Unpublished $publication->title publication" : "Published $publication->title post";
        Helper::log($statusMessage);
        return response()->json(['success' => 'Publication status updated successfully']);
    }

    public function publicationEdit($id)
    {
        $categories = PublicationCategory::where('status', 1)->get();
        $publication = Publication::with(['category'])->where('id', $id)->firstOrFail();
        return view('admin.publication.publication-edit', [
            'publication' => $publication,
            'categories' => $categories,
        ]);
    }

    public function publicationUpdate(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:publication_categories,id|integer',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'short_description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,docx,ppt',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'publish_date' => 'required|date',
        ], [
            'category.exists' => 'The selected category does not exist.',
            'category.integer' => 'The category must be a valid integer.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'author.string' => 'The author must be a string.',
            'author.max' => 'The author may not be greater than 255 characters.',
            'publisher.string' => 'The publisher must be a string.',
            'publisher.max' => 'The publisher may not be greater than 255 characters.',
            'short_description.string' => 'The short description must be a string.',
            'file.file' => 'The file must be a valid file.',
            'file.mimes' => 'The file must be a type of: pdf, docx, ppt.',
            'file.max' => 'The file may not be greater than 2MB.',
            'image.image' => 'The image must be an image.',
            'image.mimes' => 'The image must be a type of: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than 2MB.',
            'publish_date.required' => 'The publish date is required.',
            'publish_date.date' => 'The publish date must be a valid date.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Validation failed
        }
        $publication = Publication::where('id',$request->id)->first();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $dir = public_path('/frontend/images/publication/');
            // Ensure the directory exists
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $oldImagePath = public_path('/frontend/images/publication/') . $publication->image;
            // Delete the image file if it exists
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $img = Image::make($image);
            $img->save($dir . $imageName);
            $publication->image = $imageName;
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $dir = public_path('/frontend/images/publication/');

            // Ensure the directory exists
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $oldFilePath = public_path('/frontend/images/publication/') . $publication->file;
            // Delete the image file if it exists
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $file->move($dir, $fileName);
            $publication->file = $fileName;
        }
        $publication->category_id = $request->category;
        $publication->title = $request->title;
        $publication->author = $request->author;
        $publication->publisher = $request->publisher;
        $publication->publish_date = $request->publish_date;
        $publication->save();
        return $request->all();
    }
    // publicatiuon end
}
