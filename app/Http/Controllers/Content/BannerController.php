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
            $banners = Banner::latest('position')->get();
    
            return DataTables::of($banners)
                ->addColumn('title_display', function ($banner) {
                    $title = json_decode($banner->title, true);
                    if ($title) {
                        return '<div style="display: flex; align-items: center;">
                                    <span style="background-color: ' . $title['color'] . '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></span>
                                    ' . $title['text'] . '
                                </div>';
                    }
                    return '-';
                })
                ->addColumn('background_display', function ($banner) {
                    $background_color = json_decode($banner->background_color, true);
                    $overlay_color = json_decode($banner->overlay_color, true);
                    $bg_image = json_decode($banner->bg_image, true);
    
                    $bgContent = '';
                    if ($background_color && $background_color['status'] == 1) {
                        $bgContent .= '<span style="background-color: ' . $background_color['color'] . '; width: 50px; height: 50px; display: inline-block;"></span>';
                    } elseif ($bg_image && $bg_image['path']) {
                        $bgContent .= '<img src="' . asset('public/frontend/images/banner/' . $bg_image['path']) . '" alt="Background Image" style="width: 50px; height: 50px; object-fit: contain;">';
                    }
    
                    if ($overlay_color && $overlay_color['status'] == 1) {
                        $bgContent .= '<span style="background-color: ' . $overlay_color['color'] . '; width: 20px; height: 20px; display: inline-block; margin-left: 5px;"></span>';
                    }
    
                    return $bgContent;
                })
                ->addColumn('content_image_display', function ($banner) {
                    $content_image = json_decode($banner->content_image, true);
                    if ($content_image) {
                        return '<img src="' . asset('public/frontend/images/banner/' . $content_image['path']) . '" alt="Content Image" style="width: 50px; height: 50px; object-fit: contain;">';
                    }
                    return '-';
                })
                ->editColumn('status', function ($banner) {
                    return '<span class="status badge badge-light-' . ($banner->status == 1 ? 'success' : 'danger') . '" data-status="' . $banner->status . '" data-id="' . $banner->id . '">' . ($banner->status == 1 ? 'Active' : 'Deactive') . '</span>';
                })
                ->addColumn('actions', function ($banner) {
                    return '<a href="javascript:void(0)" class="edit text-primary mr-2 me-2" id="editButton" data-id="' . $banner->id . '">
                                <i class="fas fa-edit text-primary" style="font-size: 16px;"></i>
                            </a>
                            <a href="javascript:void(0)" class="text-danger delete" data-id="' . $banner->id . '">
                                <i class="fas fa-trash text-danger" style="font-size: 16px;"></i>
                            </a>';
                })
                ->rawColumns(['title_display', 'background_display', 'content_image_display', 'status', 'actions'])
                ->make(true);
        }
        return view('admin.content.banner.index');
    }
    
    public function bannerCreateOrUpdate(Request $request)
    {
        // return request()->all();
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
        if ($request->filled('id')) {
            $rules['bg_image'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1920,height=768';
            $rules['content_image'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=640,height=550';
        }
        else{
            $rules['bg_image'] = 'required_if:background_type,image|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1920,height=768';
            $rules['content_image'] = 'required_if:contentImageSwitch,on|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=640,height=550';
        }
        $rules['background_color'] = 'required_if:background_type,color|max:7';

        // Content image validation

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

        // for banner title 
        $banner->title = json_encode([
            'status' => ($request->has('titleSwitch') && $request->input('titleSwitch') === 'on') ? 1 : 0,
            'text' => $request->input('title'),
            'color' => $request->input('title_color')
        ]);

        // for banner description 
        $banner->description = json_encode([
            'status' => ($request->has('descriptionSwitch') && $request->input('descriptionSwitch') === 'on') ? 1 : 0,
            'text' => $request->input('banner_description'),
            'color' => $request->input('description_color')
        ]);    
        
        $banner->background_color = json_encode([
            'status' => $request->input('background_type') === 'color' ? 1 : 0,
            'color' => $request->input('background_color')
        ]);

        $banner->overlay_color = json_encode([
            'status' => ($request->has('overlaySwitch') && $request->input('overlaySwitch') === 'on' && $request->input('background_type') === 'image') ? 1 : 0,
            'color' => $request->input('overlay_color')
        ]);

        // for background image 
        if ($request->filled('id') && $request->input('background_type') === 'image') {
            if ($request->hasFile('bg_image')) {
                if ($banner->bg_image) {
                    $oldBgImage = json_decode($banner->bg_image)->path;
                    if ($oldBgImage && file_exists(public_path('frontend/images/banner/' . $oldBgImage))) {
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
            else{
                $banner->bg_image = $banner->bg_image;
            }
        }
        elseif($request->filled('id') && $request->input('background_type') === 'color'){
            $existingBg = json_decode($banner->bg_image, true);
            $existingBg['status'] = 0;
            $banner->bg_image = json_encode($existingBg);
        }
        else{
            if ($request->input('background_type') === 'image') {
                if ($request->hasFile('bg_image')) {
                    $bgImageName = time() . '_bg.' . $request->bg_image->extension();
                    $request->bg_image->move(public_path('frontend/images/banner'), $bgImageName);
                    $banner->bg_image = json_encode([
                        'status' => $request->input('background_type') === 'image' ? 1 : 0,
                        'path' => $bgImageName
                    ]);
                }
            }
        }
        
        // for content image 
        if ($request->filled('id') && $request->has('contentImageSwitch') && $request->input('contentImageSwitch') === 'on') {
            if ($request->hasFile('content_image')) {
                if ($banner->content_image) {
                    $oldContentImage = json_decode($banner->content_image)->path;
                    if ($oldContentImage && file_exists(public_path('frontend/images/banner/' . $oldContentImage))) {
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
            else{
                $existingContImg = json_decode($banner->content_image, true);
                $existingContImg['status'] = 1;
                $banner->content_image = json_encode($existingContImg);
            }
        }
        elseif($request->filled('id') && empty($request->has('contentImageSwitch'))){
            $existingContImg = json_decode($banner->content_image, true);
            $existingContImg['status'] = 0;
            $banner->content_image = json_encode($existingContImg);
        }
        else{
            if ($request->hasFile('content_image')) {
                $contentImageName = time() . '_content.' . $request->content_image->extension();
                $request->content_image->move(public_path('frontend/images/banner'), $contentImageName);
                $banner->content_image = json_encode([
                    'status' => $request->input('contentImageSwitch') === 'on' ? 1 : 0,
                    'path' => $contentImageName
                ]);
            }
        }
        
        if ($request->filled('id') && $request->has('add_button') && $request->input('add_button') === 'on') {
            $banner->button = json_encode([
                'status' => 1,
                'text' => $request->input('button_text'),
                'bg_color' => $request->input('button_bg_color'),
                'color' => $request->input('button_color'),
                'url' => $request->input('button_url'),
            ]);
        } elseif($request->filled('id') && !$request->has('add_button') || $request->input('add_button') !== 'on'){
            $banner->button = json_encode([
                'status' => 0,
                'text' => $request->input('button_text'),
                'bg_color' => $request->input('button_bg_color'),
                'color' => $request->input('button_color'),
                'url' => $request->input('button_url'),
            ]);
        } else {
            $banner->button = json_encode([
                'status' => $request->input('add_button') === 'on' ? 1 : 0,
                'text' => $request->input('button_text'),
                'bg_color' => $request->input('button_bg_color'),
                'color' => $request->input('button_color'),
                'url' => $request->input('button_url'),
            ]);
        }

        $banner->position = $request->input('position');
        $banner->status = 1; // Assuming status is always 1 for active banners
        $banner->added_by = auth()->id(); // Assuming the authenticated user is adding the banner

        $banner->save();

        return response()->json(['success' => 'Banner saved successfully']);
    }

    public function bannerInfo(Request $request)
    {
        $id = $request->input('id');
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['error' => 'Banner not found'], 404);
        }

        return response()->json(['banner' => [
            'id' => $banner->id,
            'title' => json_decode($banner->title, true),
            'description' => json_decode($banner->description, true),
            'bg_image' => json_decode($banner->bg_image, true),
            'content_image' => json_decode($banner->content_image, true),
            'background_color' => json_decode($banner->background_color, true),
            'overlay_color' => json_decode($banner->overlay_color, true),
            'button' => json_decode($banner->button, true),
            'position' => $banner->position
        ]]);
    }

    

    
    
    // public function bannerCreate(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'image' => 'required|image|max:2048|dimensions:width=640,height=550',
    //     ], [
    //         'image.dimensions' => 'The image must be exactly 640x550 pixels.',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
    //     }
    //     $data = $request->only(['title', 'description']);
    //     if (isset($request->image)) {
    //         $image = $request->file('image');
    //         $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
    //         $dir = public_path('/frontend/images/banner/');

    //         if (!File::exists($dir)) {
    //             File::makeDirectory($dir, 0755, true);
    //         } 

    //         // Resize the image to 415x415
    //         $img = Image::make($image);
    //         $img->save($dir . $imageName);

    //         $data['image'] = $imageName;
    //     }
    //     $data['added_by'] = Auth::guard('admin')->user()->id;
    //     Banner::updateOrCreate(
    //         ['title' => $data['title']], // Adjust the condition as needed
    //         $data
    //     );
    //     Helper::log('Banner create');
    //     // Toastr::success('You have successfully Create Banner!', 'success');
    //     return response()->json(['success' => ['success' => 'You have successfully Create Banner!']]);
    // }

    public function bannerDelete(Request $request)
    {
        $banner = Banner::findOrFail($request->id);
    
        // Delete the background image file if it exists
        if ($banner->bg_image) {
            $bgImagePath = public_path('/frontend/images/banner/') . json_decode($banner->bg_image)->path;
            if (file_exists($bgImagePath)) {
                unlink($bgImagePath);
            }
        }
    
        // Delete the content image file if it exists
        if ($banner->content_image && json_decode($banner->content_image)->path) {
            $contentImagePath = public_path('/frontend/images/banner/') . json_decode($banner->content_image)->path;
            if (file_exists($contentImagePath)) {
                unlink($contentImagePath);
            }
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
}
