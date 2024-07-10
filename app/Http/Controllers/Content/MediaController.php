<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\MediaAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MediaController extends Controller
{
    public function mediaAlbum(Request $request)
    {
        if ($request->ajax()) {
            $albums = MediaAlbum::latest();;

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
}
