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
        $mainContent = MainContent::where('name', 'aboutus-content')->first();
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
        return view('admin.content.about-us.index',);
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
            ['name' => 'aboutus-content'],  // Assuming you have a 'name' column to check against
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
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'subtitle' => 'required|string|max:255',
            'title' => 'required|string|max:255',
        ], [
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

        // if ($request->hasFile('icon')) {
        //     $image = $request->icon;
        //     $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
        //     $dir = public_path('/frontend/images/icons/');
        //     if (!File::exists($dir)) {
        //         File::makeDirectory($dir, 0755, true);
        //     }
        //     $image->move($dir, $imageName);
        // }

        // Fetch existing aboutus-feature content
        $aboutus = MainContent::where('name', 'aboutus-feature')->first();
        $content_array = [];

        if ($aboutus) {
            $content_array = json_decode($aboutus->content, true);
        }

        // Add new feature to the features array
        $newFeature = [
            // 'icon_name' => $imageName ?? null,
            'subtitle' => $request->input('subtitle'),
            'title' => $request->input('title'),
            'status' => 0,
        ];

        $content_array['feature'][$request->input('title')] = $newFeature;

        // Save updated content
        MainContent::updateOrCreate(
            ['name' => 'aboutus-feature'],
            ['content' => json_encode($content_array)]
        );

        return response()->json(['success' => ['success' => 'About us feature saved successfully']]);
    }

    public function aboutusFeatureData(Request $request)
    {
        $features = MainContent::where('name', 'aboutus-feature')->first();

        if ($features) {
            $featuresContent = json_decode($features->content, true);
            $featuresArray = [];

            if (isset($featuresContent['feature'])) {
                foreach ($featuresContent['feature'] as $key => $feature) {
                    $featuresArray[] = [
                        'title' => $feature['title'],
                        'subtitle' => $feature['subtitle'],
                        // 'icon' => $feature['icon_name'],
                        'status' => $feature['status'],
                    ];
                }
            }

            return DataTables::of($featuresArray)->make(true);
        } else {
            return DataTables::of([])->make(true);
        }
    }

    public function featureDelete(Request $request)
    {
        $title = $request->title;
        $mainContent = MainContent::where('name', 'aboutus-feature')->first();

        if ($mainContent) {
            $content = json_decode($mainContent->content, true);

            if (isset($content['feature'])) {
                $found = false;

                // Filter out the feature with the specified title and delete the icon file
                $content['feature'] = array_filter($content['feature'], function ($feature) use ($title, &$found) {
                    if ($feature['title'] === $title) {
                        $found = true;

                        // // Delete the icon file
                        // $iconPath = public_path('/frontend/images/icons/') . $feature['icon_name'];
                        // if (File::exists($iconPath)) {
                        //     File::delete($iconPath);
                        // }

                        // Return false to remove this feature from the array
                        return false;
                    }

                    // Keep this feature in the array
                    return true;
                });

                // Re-index the array
                $content['feature'] = array_values($content['feature']);

                if ($found) {
                    // Save the updated content back to the database
                    $mainContent->content = json_encode($content);
                    $mainContent->save();

                    return response()->json(['success' => 'Feature deleted successfully']);
                }
            }
        }

        return response()->json(['error' => 'Feature not found'], 404);
    }

    public function featureStatus(Request $request)
    {
        $title = $request->input('title');
        $status = $request->input('status');
        $mainContent = MainContent::where('name', 'aboutus-feature')->first();

        if ($mainContent) {
            $content = json_decode($mainContent->content, true);

            if (isset($content['feature'])) {
                $found = false;

                // Update the status of the feature with the specified title
                foreach ($content['feature'] as &$feature) {
                    if ($feature['title'] === $title) {
                        $found = true;
                        $feature['status'] = $status == 0 ? 1 : 0;
                        break;
                    }
                }

                if ($found) {
                    // Save the updated content back to the database
                    $mainContent->content = json_encode($content);
                    $mainContent->save();

                    return response()->json(['success' => 'Feature status updated successfully']);
                }
            }
        }

        return response()->json(['error' => 'Feature not found'], 404);
    }

    public function featureEdit(Request $request)
    {
        $title = $request->input('title');
        $mainContent = MainContent::where('name', 'aboutus-feature')->first();

        if ($mainContent) {
            $content = json_decode($mainContent->content, true);

            if (isset($content['feature'])) {
                foreach ($content['feature'] as $feature) {
                    if ($feature['title'] === $title) {
                        return response()->json(['feature' => $feature]);
                    }
                }
            }
        }

        return response()->json(['error' => 'Feature not found'], 404);
    }

    public function featureUpdate(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'oldTitle' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'required|string|max:255',
        ], [
            'oldTitle.required' => 'The old feature title is required.',
            'oldTitle.string' => 'The old feature title must be a string.',
            'oldTitle.max' => 'The old feature title must not be greater than 255 characters.',
            'title.string' => 'The new feature title must be a string.',
            'title.max' => 'The new feature title must not be greater than 255 characters.',
            'subtitle.required' => 'The feature subtitle is required.',
            'subtitle.string' => 'The feature subtitle must be a string.',
            'subtitle.max' => 'The feature subtitle must not be greater than 255 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $oldTitle = $request->input('oldTitle');
        $newTitle = $request->input('title', $oldTitle); // Default to old title if new title is not provided
        $subtitle = $request->input('subtitle');
        $mainContent = MainContent::where('name', 'aboutus-feature')->first();

        if ($mainContent) {
            $content = json_decode($mainContent->content, true);

            if (isset($content['feature'])) {
                $found = false;

                foreach ($content['feature'] as &$feature) {
                    if ($feature['title'] === $oldTitle) {
                        $found = true;
                        $feature['title'] = $newTitle; // Update title if changed
                        $feature['subtitle'] = $subtitle;

                        // Check if there's a new icon file
                        // if ($request->hasFile('icon')) {
                        //     // Delete the old icon file
                        //     if ($feature['icon_name']) {
                        //         $oldIconPath = public_path('/frontend/images/icons/') . $feature['icon_name'];
                        //         if (File::exists($oldIconPath)) {
                        //             File::delete($oldIconPath);
                        //         }
                        //     }

                        //     // Upload and store the new icon file
                        //     $icon = $request->file('icon');
                        //     $imageName = Str::uuid() . '.' . $icon->getClientOriginalExtension();
                        //     $dir = public_path('/frontend/images/icons/');
                        //     $icon->move($dir, $imageName);

                        //     $feature['icon_name'] = $imageName;
                        // }

                        break;
                    }
                }

                if ($found) {
                    // Save the updated content back to the database
                    $mainContent->content = json_encode($content);
                    $mainContent->save();

                    return response()->json(['success' => 'Feature updated successfully']);
                }
            }
        }

        return response()->json(['error' => 'Feature not found'], 404);
    }
}
