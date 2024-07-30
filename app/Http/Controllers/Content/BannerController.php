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
use Illuminate\Support\Facades\Storage;

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

    public function bannerCreateOrUpdate(Request $request)
    {
        $rules = [
            'background_type' => 'required',
            'overlay_color' => 'nullable',
            'bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_text' => 'nullable|max:255',
            'button_bg_color' => 'nullable|max:7',
            'button_color' => 'nullable|max:7',
            'button_url' => 'nullable|url|max:255',
            'position' => 'nullable|integer'
        ];
    
        // Title validation
        $rules['title'] = 'required_if:titleSwitch,on|max:255';
        $rules['title_color'] = 'required_if:titleSwitch,on|max:7';
    
        // Description validation
        $rules['banner_description'] = 'required_if:descriptionSwitch,on';
        $rules['description_color'] = 'required_if:descriptionSwitch,on|max:7';
    
        // Background type validation
        $rules['bg_image'] = 'required_if:background_type,image|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        $rules['background_color'] = 'required_if:background_type,color|max:7';
    
        // Content image validation
        $rules['content_image'] = 'required_if:contentImageSwitch,on|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
    
        // Button validation
        $rules['button_text'] = 'required_if:add_button,on|max:255';
        $rules['button_bg_color'] = 'required_if:add_button,on|max:7';
        $rules['button_color'] = 'required_if:add_button,on|max:7';
        $rules['button_url'] = 'required_if:add_button,on|max:255';
    
        $request->validate($rules);
    
        if ($request->filled('id')) {
            $banner = Banner::find($request->id);
            if (!$banner) {
                return response()->json(['error' => 'Banner not found'], 404);
            }
        } else {
            $banner = new Banner();
            $lastPosition = Banner::max('position');
            $request->merge(['position' => $lastPosition + 1]);
        }
    
        $banner->title = json_encode([
            'status' => $request->input('titleSwitch') === 'on' ? 1 : 0,
            'text' => $request->input('title'),
            'color' => $request->input('title_color')
        ]);
    
        $banner->description = json_encode([
            'status' => $request->input('descriptionSwitch') === 'on' ? 1 : 0,
            'text' => $request->input('banner_description'),
            'color' => $request->input('description_color')
        ]);
    
        $banner->background_color = json_encode([
            'status' => $request->input('background_type') === 'color' ? 1 : 0,
            'color' => $request->input('background_color')
        ]);
    
        $banner->overlay_color = json_encode([
            'status' => $request->input('background_type') === 'image' ? 1 : 0,
            'color' => $request->input('overlay_color')
        ]);
    
        if ($request->hasFile('bg_image')) {
            if ($banner->bg_image) {
                $oldBgImage = json_decode($banner->bg_image)->path;
                if (file_exists(public_path('frontend/images/banner/' . $oldBgImage))) {
                    unlink(public_path('frontend/images/banner/' . $oldBgImage));
                }
            }
            $bgImageName = time() . '_bg.' . $request->bg_image->extension();
            $request->bg_image->move(public_path('frontend/images/banner'), $bgImageName);
            $banner->bg_image = json_encode([
                'status' => $request->input('background_type') === 'image' ? 1 : 0,
                'path' => $bgImageName
            ]);
        }
    
        if ($request->hasFile('content_image')) {
            if ($banner->content_image) {
                $oldContentImage = json_decode($banner->content_image)->path;
                if (file_exists(public_path('frontend/images/banner/' . $oldContentImage))) {
                    unlink(public_path('frontend/images/banner/' . $oldContentImage));
                }
            }
            $contentImageName = time() . '_content.' . $request->content_image->extension();
            $request->content_image->move(public_path('frontend/images/banner'), $contentImageName);
            $banner->content_image = json_encode([
                'status' => $request->input('contentImageSwitch') === 'on' ? 1 : 0,
                'path' => $contentImageName
            ]);
        }
    
        if ($request->has('add_button') && $request->input('add_button') == 'on') {
            $banner->button = json_encode([
                'status' => 1,
                'text' => $request->input('button_text'),
                'bg_color' => $request->input('button_bg_color'),
                'color' => $request->input('button_color'),
                'url' => $request->input('button_url'),
            ]);
        } else {
            $banner->button = json_encode(['status' => 0]);
        }
    
        $banner->position = $request->input('position');
        $banner->status = 1; // Assuming status is always 1 for active banners
        $banner->added_by = auth()->id(); // Assuming the authenticated user is adding the banner
    
        $banner->save();
    
        return response()->json(['success' => 'Banner saved successfully']);
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
