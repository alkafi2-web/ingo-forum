<?php

namespace App\Http\Controllers\UserManual;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\MainContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UserManualController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the manual entries from the MainContent model
        $manuals = MainContent::whereIn('name', ['admin_manual', 'member_manual'])->get();
        if ($request->ajax()) {

            return datatables()->of($manuals)
                ->addIndexColumn() // Adds the index column for numbering
                ->addColumn('manual_type', function ($row) {
                    return ucfirst(explode('_', $row->name)[0]);
                })
                ->addColumn('actions', function ($row) {
                    $downloadUrl = url('public/frontend/user-manual/' . $row->content);
                    return '<a href="' . $downloadUrl . '" class="btn btn-primary btn-sm" target="_blank">
                                <i class="fas fa-download"></i>
                            </a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.user-manual.add-user-manual', compact('manuals'));
    }
    public function create(Request $request)
    {
        $messages = [
            'manual_type.required' => 'The manual type is required.',
            'manual_file.required' => 'Please upload a manual file.',
            'manual_file.mimes' => 'The manual file must be a file of type: pdf, doc, docx.',
            'manual_file.max' => 'The manual file may not be greater than 10MB.',
        ];

        // Validate the form data
        $validator = Validator::make($request->all(), [
            'manual_type' => 'required|string|in:admin_manual,member_manual',
            'manual_file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max size
        ], $messages);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Initialize filename variable
        $filename = null;

        // Check if there's an existing manual entry
        $existingManual = MainContent::where('name', $request->manual_type)->first();

        // Store the new file and delete the old one
        if ($request->hasFile('manual_file')) {
            $file = $request->file('manual_file');
            $filename = $request->manual_type . '-' . $file->getClientOriginalName();
            $dir = public_path('/frontend/user-manual/');

            // Create directory if it doesn't exist
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            // Delete the old file if it exists
            if ($existingManual && File::exists($dir . $existingManual->content)) {
                File::delete($dir . $existingManual->content);
            }

            // Move the new file to the directory
            $file->move($dir, $filename);
        }

        // Update or create record in MainContent
        MainContent::updateOrCreate(
            ['name' => $request->manual_type],
            ['content' => $filename]
        );

        return response()->json(['status' => 'success', 'message' => 'Manual uploaded and saved successfully.']);
    }
    public function delete(Request $request)
    {
        $manual = MainContent::findOrFail($request->id);
        $filepath = public_path('/frontend/user-manual/') . $manual->content;
        // Delete the image file if it exists
        if (file_exists($filepath)) {
            unlink($filepath);
        }
        $manual->delete();
        Helper::log("Delete $manual->name ");
        return response()->json(['success' => "$manual->name deleted successfully"]);
    }

    public function adminManual()
    {

        $manual = MainContent::where('name', 'admin_manual')->first();
        // Pass the file URL to the view
        if ($manual) {
            // Generate the full file URL
            $fileUrl = asset('public/frontend/user-manual/' . $manual->content);
        } else {
            $fileUrl = null; // Handle the case where no manual is found
        }

        // Return the view with the file URL
        return view('admin.user-manual.view-manual', compact('fileUrl'));
    }
}
