<?php

namespace App\Http\Controllers\Content;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $banners = Banner::latest();

            return DataTables::of($banners)
                ->make(true);
        }
        return view('admin.content.banner.index');
    }

    public function bannerCreate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048|dimensions:width=640,height=550',
        ], [
            'image.dimensions' => 'The image must be exactly 640x550 pixels.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
        $data = $request->only(['title', 'description']);
        if (isset($request->image)) {
            $image = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $dir = public_path('/frontend/images/banner/');

            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            } 

            // Resize the image to 415x415
            $img = Image::make($image);
            $img->save($dir . $imageName);

            $data['image'] = $imageName;
        }
        $data['added_by'] = Auth::guard('admin')->user()->id;
        Banner::updateOrCreate(
            ['title' => $data['title']], // Adjust the condition as needed
            $data
        );
        Helper::log('Banner create');
        // Toastr::success('You have successfully Create Banner!', 'success');
        return response()->json(['success' => ['success' => 'You have successfully Create Banner!']]);
    }

    public function bannerDelete(Request $request)
    {
        $banner = Banner::findOrFail($request->id);
        $bannerImagePath = public_path('/frontend/images/banner/') . $banner->image;
        // Delete the image file if it exists
        if (file_exists($bannerImagePath)) {
            unlink($bannerImagePath);
        }

        // Delete the banner record
        $banner->delete();
        Helper::log('Banner delete');
        return response()->json(['success' => 'Banner deleted successfully']);
    }
    public function bannerStatus(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        $banner = Banner::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $banner->status = $newStatus;

        // Save the changes to the database
        $banner->save();
        $statusMessage = $newStatus == 0 ? 'Banner Deactive' : 'Banner Active';
        Helper::log($statusMessage);
        return response()->json(['success' => 'Banner status updated successfully']);
    }
    public function bannerEdit(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        // return $request->all();
        $banner = Banner::findOrFail($request->id);

        return response()->json(['banner' => $banner]);
    }

    public function bannerUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048|dimensions:width=640,height=550',
        ], [
            'image.dimensions' => 'The image must be exactly 640x550 pixels.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['title', 'description']);
        $banner = Banner::findOrFail($request->id);

        // Handle image update if a new image is provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $dir = public_path('/frontend/images/banner/');

            // Ensure the directory exists
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            // Remove old image if exists
            $oldImagePath = $dir . $banner->image;
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            // Move new image to directory
            $image->move($dir, $imageName);
            $data['image'] = $imageName;
        }

        // Update banner data
        $data['added_by'] = Auth::guard('admin')->user()->id;
        $banner->update($data);
        Helper::log('Banner update');
        return response()->json(['success' => ['success' => 'Banner updated successfully']]);
    }
}
