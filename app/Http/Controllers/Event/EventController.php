<?php

namespace App\Http\Controllers\Event;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function event(Request $request)
    {
        if (!Auth::guard('admin')->user()->hasPermissionTo('event-view')) {
            abort(401);
        }
        if ($request->ajax()) {
            $events = Event::with('creator')->latest();

            return DataTables::of($events)
                ->addColumn('creator', function ($event) {
                    return $event->creator->name ?? $event->creator->info->organisation_name;
                })
                
                ->make(true);
        }
        return view('admin.event.index');
    }

    public function eventCreate(Request $request)
    {
        // return $request->all();
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'des' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'deadline_date' => $request->has('check_deadline') ? 'required|date|before:end_date' : 'nullable|date|before:end_date',
            'location' => 'required|string',
            'capacity' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            // Custom error messages
            'title.required' => 'Title is required.',
            'des.required' => 'Description is required.',
            'start_date.required' => 'Start Date is required.',
            'start_date.date' => 'Start Date must be a valid date.',
            'end_date.required' => 'End Date is required.',
            'end_date.date' => 'End Date must be a valid date.',
            'end_date.after' => 'End Date must be after Start Date.',
            'deadline_date.required' => 'Deadline Date is required when the checkbox is checked.',
            'deadline_date.date' => 'Deadline Date must be a valid date.',
            'deadline_date.before' => 'Deadline Date must be before End Date.',
            'location.required' => 'Location Fee is required.',
            'image.required' => 'Image is required.',
            'image.image' => 'Image must be an image file.',
            'image.mimes' => 'Image must be a JPEG, PNG, JPG, or GIF image.',
            'image.max' => 'Image size should not exceed 2MB.',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Validation failed
        }
        if (isset($request->image)) {
            $image = $request->image;
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $dir = public_path('/frontend/images/events/');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $image->move($dir, $imageName);
        }
        // return $regDeadline = $request->check_deadline ? $request->deadline_date : null;
        $regEnableStatus = $request->has('check_deadline') ? 1 : 0;

        // Create the event
        Event::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'details' => $request->des,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reg_dead_line' => $request->deadline_date,
            'reg_enable_status' => $regEnableStatus,
            'location' => $request->location,
            'capacity' => $request->capacity, // Include capacity field
            'media' => $imageName ?? null, // Save image name or path to database
            'creator_type' => $request->creator_type,
            'creator_id' => $request->creator_type == '\App\Models\User' ? Auth::guard('admin')->id() : Auth::guard('member')->id(),
            'approval_status' => $request->creator_type == '\App\Models\User' ? null : 0,
        ]);
        Helper::log("Create $request->title event");
        return response()->json(['success' => ['success' => 'You have successfully Create Event!']]);
    }

    public function eventDelete(Request $request)
    {
        $event = Event::findOrFail($request->id);
        $bannerImagePath = public_path('/frontend/images/events/') . $event->media;
        // Delete the image file if it exists
        if (file_exists($bannerImagePath)) {
            unlink($bannerImagePath);
        }

        // Delete the banner record
        $event->delete();
        Helper::log("Delete $event->title event");
        return response()->json(['success' => 'Event deleted successfully']);
    }

    public function eventStatus(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        $event = Event::findOrFail($request->id);

        // Toggle the status
        $newStatus = $request->status == 0 ? 1 : 0;

        // Update the status attribute
        $event->status = $newStatus;

        // Save the changes to the database
        $event->save();
        $statusMessage = $newStatus == 0
            ? "$event->title event status deactive"
            : "$event->title event status active";
        Helper::log($statusMessage);
        return response()->json(['success' => 'Event status updated successfully']);
    }

    public function eventEdit(Request $request)
    {
        // Find the banner by ID or throw an exception if not found
        // return $request->all();
        $event = Event::findOrFail($request->id);

        return response()->json(['event' => $event]);
    }

    public function eventUpdate(Request $request)
    {
        // return $request->all();
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:events,id',
            'title' => 'required|string|max:255',
            'des' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'deadline_date' => $request->has('check_deadline') ? 'required|date|before:end_date' : 'nullable|date|before:end_date',
            'location' => 'required|string',
            'capacity' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            // Custom error messages
            'id.required' => 'Event ID is required.',
            'id.exists' => 'Event not found.',
            'title.required' => 'Title is required.',
            'des.required' => 'Description is required.',
            'start_date.required' => 'Start Date is required.',
            'start_date.date' => 'Start Date must be a valid date.',
            'end_date.required' => 'End Date is required.',
            'end_date.date' => 'End Date must be a valid date.',
            'end_date.after' => 'End Date must be after Start Date.',
            'deadline_date.required' => 'Deadline Date is required when the checkbox is checked.',
            'deadline_date.date' => 'Deadline Date must be a valid date.',
            'deadline_date.before' => 'Deadline Date must be before End Date.',
            'location.required' => 'Location is required.',
            'image.image' => 'Image must be an image file.',
            'image.mimes' => 'Image must be a JPEG, PNG, JPG, or GIF image.',
            'image.max' => 'Image size should not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the event by ID
        $event = Event::findOrFail($request->id);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $dir = public_path('/frontend/images/events/');

            // Ensure the directory exists
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            // Delete old image if exists
            if ($event->media && File::exists($dir . $event->media)) {
                File::delete($dir . $event->media);
            }

            // Move new image to directory
            $image->move($dir, $imageName);

            // Update event with new image
            $event->update([
                'media' => $imageName,
            ]);
        }

        // Update other event details
        $event->update([
            'title' => $request->title,
            'details' => $request->des,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reg_dead_line' => $request->deadline_date,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'reg_enable_status' => $request->has('check_deadline') ? 1 : 0,
        ]);

        Helper::log("Update {$event->title} event");
        return response()->json(['success' => ['success' => 'Event updated successfully']]);
    }

    public function memberEventList(Request $request)
    {

        if ($request->ajax()) {
            $events = Event::latest();;

            return DataTables::of($events)
                ->make(true);
        }
        return view('admin.event.index');
    }
}
