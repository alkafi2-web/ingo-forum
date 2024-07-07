<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\MainContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class AboutusController extends Controller
{
    public static function index(Request $request)
    {
        // $aboutus_content = MainContent::where('name', 'aboutus')->first()->content;

        $mainContent = MainContent::where('name', 'aboutus')->first();
        if ($request->ajax()) {

            if ($mainContent) {
                $aboutus_content = $mainContent->content;
                $aboutus = json_decode($aboutus_content);
                $content = $aboutus->content;
                return DataTables::of(collect([$content]))  // Wrap in collect to ensure DataTables works
                    ->make(true);
            } else {
                return DataTables::of(collect([]))
                    ->make(true);
            }
        }
        return view('admin.content.about-us.index');
    }
    public function aboutusCreate(Request $request)
    {
        // Custom error messages
        $messages = [
            'title.required' => 'The About Us Title is required.',
            'title.string' => 'The About Us Title must be a string.',
            'title.max' => 'The About Us Title may not be greater than 255 characters.',
            'slogan.required' => 'The About Us Slogan is required.',
            'slogan.string' => 'The About Us Slogan must be a string.',
            'slogan.max' => 'The About Us Slogan may not be greater than 255 characters.',
            'description.required' => 'The About Us Description is required.',
            'description.string' => 'The About Us Description must be a string.',
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slogan' => 'required|string|max:255',
            'description' => 'required|string',
        ], $messages);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        // return $request->all();
        // Get validated data
        $validatedData = $validator->validated();
        $content_array['content'] = [
            'title' => $validatedData['title'],
            'slogan' => $validatedData['slogan'],
            'description' => $validatedData['description'],
            'status' => 0,
        ];

        // Update or create Aboutus data
        $aboutus = MainContent::updateOrCreate(
            ['name' => 'aboutus'],  // Assuming you have a 'name' column to check against
            [
                'content' => json_encode($content_array),
            ]
        );
        return response()->json(['success' => ['success' => 'About us content save successfully']]);
    }

    public function aboutuscontentEdit(Request $request)
    {
        return $request->all();
    }

    public function aboutusFeatureCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'subtitle' => 'required|string|max:255',
            'title' => 'required|string|max:255',
        ], [
            'icon.required' => 'The feature icon is required.',
            'icon.image' => 'The feature icon must be an image file.',
            'icon.mimes' => 'The feature icon must be a file of type: jpeg, png, jpg, gif, svg.',
            'icon.max' => 'The feature icon must not be greater than 2MB.',
            'subtitle.required' => 'The feature subtitle is required.',
            'subtitle.string' => 'The feature subtitle must be a string.',
            'subtitle.max' => 'The feature subtitle must not be greater than 255 characters.',
            'title.required' => 'The feature title is required.',
            'title.string' => 'The feature title must be a string.',
            'title.max' => 'The feature title must not be greater than 255 characters.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        // If validation passes, process the file upload and rename it
        if ($request->hasFile('icon')) {
            $image = $request->icon;
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $dir = public_path('/frontend/images/icons/');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $image->move($dir, $imageName);
        }

        // Prepare the JSON response data
        $responseData[$request->input('title')] = [
            'icon_name' => $imageName ?? null,
            'subtitle' => $request->input('subtitle'),
            'title' => $request->input('title'),
        ];
        $aboutus = MainContent::where('name', 'aboutus')->first();
        $aboutus_content = $aboutus->content;
        $aboutus_decode = json_decode($aboutus_content,true);
        
        // $aboutus_decode['feature'][] = json_encode($responseData);
        $aboutus_decode['feature'][] = $responseData;
        $aboutus->content = json_encode($aboutus_decode);
        $aboutus->save();
        return response()->json(['success' => ['success' => 'About us feature save successfully']]);

    }
}
