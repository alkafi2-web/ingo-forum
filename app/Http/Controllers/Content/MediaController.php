<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\MediaAlbum;
use App\Models\MediaGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function mediaAlbum(Request $request)
    {
        // return $albums = MediaAlbum::with(['mediaGalleries' => function ($query) {
        //     $query->where('status', 1);
        // }])
        //     ->where('status', 1)
        //     ->take(3)
        //     ->get();
        //  $albums->media_galleries;
        $albums = MediaAlbum::with([
            'mediaGalleries' => function ($query) {
                $query->where('status', 1);
            },
            'addedBy' // Include the user relationship
        ])->get();

        if ($request->ajax()) {
            $albums = MediaAlbum::latest();

            return DataTables::of($albums)
                ->make(true);
        }
        return view('admin.media.media-album');
    }

    public function albumCreate(Request $request)
    {
        // Define custom error messages
        $messages = [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than :max characters.',
            'title.unique' => 'The title has already been taken.',
            'content.required' => 'The content field is required.',
            'content.string' => 'The content must be a string.',
            'subcontent.required' => 'The sub content field is required.',
            'subcontent.string' => 'The sub content must be a string.',
            'albumtype.required' => 'The album type field is required.',
            'albumtype.in' => 'The album type must be either "photo" or "video".',
        ];

        // Validate incoming data with custom messages and unique rule for title
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:media_albums', // Add your table name where you store titles
            'content' => 'required|string',
            'subcontent' => 'required|string',
            'albumtype' => 'required|in:photo,video',
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $request->merge(['added_by' => auth()->id()]);
        $mediaAlbum = MediaAlbum::create($request->all());
        return response()->json(['success' => ['success' => 'You have successfully Create Media Album!']]);
    }

    public function albumDelete(Request $request)
    {
        $album = MediaAlbum::findOrFail($request->id);
        // Delete the banner record
        $album->delete();

        return response()->json(['success' => 'Media Album deleted successfully']);
    }

    public function albumStatus(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        $album = MediaAlbum::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $album->status = $newStatus;

        // Save the changes to the database
        $album->save();

        return response()->json(['success' => 'Album status updated successfully']);
    }
    public function albumEdit(Request $request)
    {
        $album = MediaAlbum::findOrFail($request->id);

        return response()->json(['album' => $album]);
    }

    public function albumUpdate(Request $request)
    {
        // Define custom error messages
        $messages = [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than :max characters.',
            'title.unique' => 'The title has already been taken.',
            'content.required' => 'The content field is required.',
            'content.string' => 'The content must be a string.',
            'subcontent.required' => 'The sub content field is required.',
            'subcontent.string' => 'The sub content must be a string.',
            'albumtype.required' => 'The album type field is required.',
            'albumtype.in' => 'The album type must be either "photo" or "video".',
        ];

        // Validate incoming data with custom messages and unique rule for title
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:media_albums,title,' . $request->id,
            'content' => 'required|string',
            'subcontent' => 'required|string',
            'albumtype' => 'required|in:photo,video',
        ], $messages);
        // Return validation errors as JSON if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Find the MediaAlbum by ID
        $mediaAlbum = MediaAlbum::findOrFail($request->id);

        // Update the MediaAlbum with validated data
        $mediaAlbum->update($request->all());
        return response()->json(['success' => ['success' => 'You have successfully Update Media Album!']]);
    }

    public function photoIndex(Request $request)
    {

        if ($request->ajax()) {
            $album_filter = $request->input('album_filter');
            $status_filter = $request->input('status_filter');

            $query = MediaGallery::where('type', 'photo')
                ->whereHas('mediaAlbum', function ($query) {
                    $query->where('status', 1);
                })
                ->with(['mediaAlbum' => function ($query) {
                    $query->where('status', 1);
                }])
                ->latest();

            if ($album_filter) {
                $query->whereHas('mediaAlbum', function ($query) use ($album_filter) {
                    $query->where('id', $album_filter);
                });
            }
            if ($status_filter !== null) {
                $query->where('status', $status_filter);
            }

            $photos = $query->get();

            return DataTables::of($photos)
                ->addColumn('album_name', function ($photo) {
                    return $photo->mediaAlbum->title; // Adjust according to your actual column name
                })
                ->make(true);
        }
        $albums = MediaAlbum::where([
            ['status', '=', 1],
            ['albumtype', '=', 'photo']
        ])->get();

        return view('admin.media.photo-index', [
            'albums' => $albums,
        ]);
    }
    public function photoCreate(Request $request)
    {
        $messages = [
            'album_id.required' => 'The album ID is required.',
            'album_id.exists' => 'The selected album does not exist.',
            'images.required' => 'At least one image is required.',
            'images.max' => 'You may not upload more than 10 images.',
            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'Each image may not be greater than :max kilobytes.',
        ];

        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'album_id' => 'required|exists:media_albums,id',
            'images' => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        foreach ($request->file('images') as $image) {
            $image = $image;
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $dir = public_path('/frontend/images/photo-gallery/');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $image->move($dir, $imageName);
            MediaGallery::create([
                'album_id' => $request->album_id,
                'type' => 'photo',
                'media' => $imageName,
                'status' => 1,
                'added_by' => auth()->id(),
            ]);
        }
        return response()->json(['success' => ['success' => 'You have successfully Add Photo In Album!']]);
    }

    public function photoDelete(Request $request)
    {
        $photo = MediaGallery::findOrFail($request->id);
        $photoImagePath = public_path('/frontend/images/photo-gallery/') . $photo->media;
        // Delete the image file if it exists
        if (file_exists($photoImagePath)) {
            unlink($photoImagePath);
        }

        // Delete the banner record
        $photo->delete();

        return response()->json(['success' => 'Photo deleted successfully']);
    }
    public function photoStatus(Request $request)
    {
        $photo = MediaGallery::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $photo->status = $newStatus;

        // Save the changes to the database
        $photo->save();

        return response()->json(['success' => 'Photo status updated successfully']);
    }
    public function photoEdit(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        // return $request->all();
        $photo = MediaGallery::findOrFail($request->id);

        return response()->json(['photo' => $photo]);
    }

    public function photoUpdate(Request $request)
    {
        $messages = [
            'album_id.required' => 'The album ID is required.',
            'album_id.exists' => 'The selected album does not exist.',
            'images.required' => 'At least one image is required.',
            'images.max' => 'You may not upload more than 1 image.',
            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'Each image may not be greater than :max kilobytes.',
        ];

        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'album_id' => 'required|exists:media_albums,id',
            'images' => 'array|max:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $photo = MediaGallery::findOrFail($request->id);

        // Handle image update if a new image is provided
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $image = $image;
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $dir = public_path('/frontend/images/photo-gallery/');
                $oldImagePath = $dir . $photo->media;
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
                if (!File::exists($dir)) {
                    File::makeDirectory($dir, 0755, true);
                }
                $image->move($dir, $imageName);
                $photo->update([
                    'media' => $imageName,
                ]);
            }
        }
        $photo->update([
            'album_id' => $request->album_id,
        ]);
        return response()->json(['success' => ['success' => 'You have successfully Update Photo In Album!']]);
    }


    public function videoIndex(Request $request)
    {

        if ($request->ajax()) {
            $videos = MediaGallery::where('type', 'video')->latest()->get();

            return DataTables::of($videos)
                ->make(true);
        }
        return view('admin.media.video-index');
    }

    public function videoCreate(Request $request)
    {
        // Define validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048|dimensions:width=650,height=410' // Ensure image is required and validate type and size
        ];

        // Define custom error messages
        $messages = [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'url.required' => 'The URL field is required.',
            'url.string' => 'The URL must be a string.',
            'url.max' => 'The URL may not be greater than 255 characters.',
            'content.required' => 'The content field is required.',
            'content.string' => 'The content must be a string.',
            'content.max' => 'The content may not be greater than 255 characters.',
            'image.required' => 'The Thumnil field is required.',
            'image.mimes' => 'The Thumnil must be a file of type: jpeg, jpg, png.',
            'image.max' => 'The Thumnil may not be greater than 2048 kilobytes.',
            'image.dimensions' => 'The Thumnil must be 650px by 410px.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Return errors as JSON
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Process and store the image
        $imageName = null;
        if (isset($request->image)) {
            $image = $request->image;
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $dir = public_path('/frontend/images/video-thumbnail/');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $image->move($dir, $imageName);
        }

        // Store the data in the database
        MediaGallery::create([
            'type' => 'video',
            'name' => $request->title,
            'url' => $request->url,
            'content' => $request->content,
            'media' => $imageName,
            'added_by' => auth()->id(),
        ]);
        return response()->json(['success' => ['success' => 'You have successfully Upload Video!']]);
    }

    public function videoDelete(Request $request)
    {
        $video = MediaGallery::findOrFail($request->id);
        $videoThumnailPath = public_path('/frontend/images/video-thumbnail/') . $video->media;
        // Delete the image file if it exists
        if (file_exists($videoThumnailPath)) {
            unlink($videoThumnailPath);
        }

        // Delete the banner record
        $video->delete();

        return response()->json(['success' => 'Video deleted successfully']);
    }
    public function videoStatus(Request $request)
    {
        $video = MediaGallery::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $video->status = $newStatus;

        // Save the changes to the database
        $video->save();

        return response()->json(['success' => 'Video status updated successfully']);
    }
    public function videoEdit(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        // return $request->all();
        $video = MediaGallery::findOrFail($request->id);

        return response()->json(['video' => $video]);
    }
    public function videoUpdate(Request $request)
    {
        // Define validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048|dimensions:width=650,height=410' // Ensure image is required and validate type and size
        ];

        // Define custom error messages
        $messages = [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'url.required' => 'The URL field is required.',
            'url.string' => 'The URL must be a string.',
            'url.max' => 'The URL may not be greater than 255 characters.',
            'content.required' => 'The content field is required.',
            'content.string' => 'The content must be a string.',
            'content.max' => 'The content may not be greater than 255 characters.',
            'image.mimes' => 'The image must be a file of type: jpeg, jpg, png.',
            'image.max' => 'The image may not be greater than 2048 kilobytes.',
            'image.dimensions' => 'The Thumnil must be 650px by 410px.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Return errors as JSON
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $video = MediaGallery::findOrFail($request->id);
        // // Process and store the image
        // $imageName = null;
        if (isset($request->image)) {
            $image = $request->image;
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $dir = public_path('/frontend/images/video-thumbnail/');
            $oldImagePath = $dir . $video->media;
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $image->move($dir, $imageName);
            $video->update([
                'media' => $imageName,
            ]);
        }

        $video->update([
            'name' => $request->title,
            'url' => $request->url,
            'content' => $request->content,
        ]);
        return response()->json(['success' => ['success' => 'You have successfully Update Video!']]);
    }
}
