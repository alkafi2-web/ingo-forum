<?php

namespace App\Http\Controllers\Member;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Member;
use App\Models\MemberInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Mail\MailException;

class MemberController extends Controller
{
    public function memberlist(Request $request)
    {

        if (!Auth::user()->hasPermissionTo('member-list-view')) {
            abort(401);
        }
        // return $members = Member::where('status', 0)->with('memberInfos')->get();
        if ($request->ajax()) {
            $organizationType = $request->organization;
            $statusFilter = $request->status_filter;
            $members = Member::with('memberInfos')->get();
            // If organization type is provided, filter the members
            if (!empty($organizationType)) {
                $members = $members->filter(function ($member) use ($organizationType) {
                    return $member->memberInfos->first() && $member->memberInfos->first()->organisation_type == $organizationType;
                });
            }
            if ($statusFilter !== null && $statusFilter !== '') {
                $members = $members->filter(function ($member) use ($statusFilter) {
                    return $member->status == $statusFilter;
                });
            }
            return DataTables::of($members)
                ->addColumn('organisation_name', function ($member) {
                    return optional($member->memberInfos->first())->organisation_name ?? 'N/A';
                })
                ->addColumn('director_name', function ($member) {
                    return optional($member->memberInfos->first())->director_name ?? 'N/A';
                })
                ->addColumn('organisation_ngo_reg', function ($member) {
                    return optional($member->memberInfos->first())->organisation_ngo_reg ?? 'N/A';
                })
                ->addColumn('org_type', function ($member) {
                    return optional($member->memberInfos->first())->organisation_type ?? 'N/A';
                })
                ->make(true);
        }
        return view('admin.member.member-list');
    }
    public function memberRequest(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('member-request-view')) {
            abort(401);
        }
        // return $members = Member::where('status', 0)->with('memberInfos')->get();
        if ($request->ajax()) {
            $members = Member::where('status', 0)->with('memberInfos')->get();
            return DataTables::of($members)
                ->addColumn('organisation_name', function ($member) {
                    return optional($member->memberInfos->first())->organisation_name ?? 'N/A';
                })
                ->addColumn('director_name', function ($member) {
                    return optional($member->memberInfos->first())->director_name ?? 'N/A';
                })
                ->addColumn('organisation_ngo_reg', function ($member) {
                    return optional($member->memberInfos->first())->organisation_ngo_reg ?? 'N/A';
                })
                ->addColumn('org_type', function ($member) {
                    return optional($member->memberInfos->first())->organisation_type ?? 'N/A';
                })
                ->make(true);
        }
        return view('admin.member.member-request');
    }

    public function view($id)
    {
        if (!Auth::guard('admin')->user()?->hasAnyPermission(['member-request-view', 'member-list-view'])) {
            abort(401);
        }
        $member = Member::where('id', $id)->with('memberInfos')->first();

        return view('admin.member.member-view', compact('member'));
    }
    public function approved(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('member-management')) {
            abort(401);
        }
        // Find the member by ID
        $member = Member::with('memberInfos', 'info')->findOrFail($request->id);
        $member->status = 1;
        if ($member->memberInfos[0]['membership_id'] == null) {
            // Get the latest membership_id and generate a new one
            $latestMembershipId = MemberInfo::whereNotNull('membership_id')->max('membership_id');
            // Parse the latest membership_id to get the numeric part
            if ($latestMembershipId) {
                $latestNumber = intval(substr($latestMembershipId, -3));
                $nextNumber = $latestNumber + 1;
            } else {
                // If no existing membership_id, start from 1
                $nextNumber = 1;
            }

            // Generate the new membership_id in the format 'AF-05-04-143'
            $newMembershipId = date('y-m-d') . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            // Update the memberInfo with the new membership_id
            $memberInfo = $member->memberInfos[0];
            $memberInfo->membership_id = $newMembershipId;
            $newMembershipId;
            $memberInfo->save();
        }
        // Update the status to 1 (or any appropriate value for "suspended")
        // Assuming 1 means suspended status

        // Save the changes
        $member->save(); // Render the view with admin.member.partials.view-header
        // Render view-header.blade.php
        $viewHeader = view('admin.member.partials.view-header', compact('member'))->render();

        // Render profile-image-name.blade.php (assuming $profileImageName is available in your context)
        $profileImageName = view('admin.member.partials.profile-image-name', compact('member'))->render();
        Helper::log("Approved " . $member->info->organisation_name);
        // Return JSON response with success message and rendered partial views
        return response()->json([
            'success' => 'Member Approved successfully',
            'viewHeader' => $viewHeader,
            'profileImageName' => $profileImageName
        ]);
    }
    public function suspend(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('member-management')) {
            abort(401);
        }
        // Find the member by ID
        $member = Member::with('memberInfos')->findOrFail($request->id);

        // Update the status to 1 (or any appropriate value for "suspended")
        $member->status = 2; // Assuming 1 means suspended status

        // Save the changes
        $member->save();
        // Render view-header.blade.php
        $viewHeader = view('admin.member.partials.view-header', compact('member'))->render();

        // Render profile-image-name.blade.php (assuming $profileImageName is available in your context)
        $profileImageName = view('admin.member.partials.profile-image-name', compact('member'))->render();
        $memberInfo = $member->memberInfos[0];
        Helper::log("Suspended " . $memberInfo->organisation_name);
        // Return JSON response with success message and rendered partial views
        return response()->json([
            'success' => 'Member Approved successfully',
            'viewHeader' => $viewHeader,
            'profileImageName' => $profileImageName
        ]);
        return response()->json(['success' => 'Member Suspend successfully']);
    }
    public function reject(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('member-management')) {
            abort(401);
        }
        // Find the member by ID
        $member = Member::with('memberInfos')->findOrFail($request->id);

        // Update the status to 1 (or any appropriate value for "suspended")
        $member->status = 3; // Assuming 1 means suspended status

        // Save the changes
        $member->save();
        // Render view-header.blade.php
        $viewHeader = view('admin.member.partials.view-header', compact('member'))->render();

        // Render profile-image-name.blade.php (assuming $profileImageName is available in your context)
        $profileImageName = view('admin.member.partials.profile-image-name', compact('member'))->render();
        $memberInfo = $member->memberInfos[0];
        Helper::log("Rejected " . $memberInfo->organisation_name);
        // Return JSON response with success message and rendered partial views
        return response()->json([
            'success' => 'Member Approved successfully',
            'viewHeader' => $viewHeader,
            'profileImageName' => $profileImageName
        ]);
    }

    public function memberFeedbackStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:255', // Added max validation rule
        ], [
            'message.required' => 'The feedback message is required.',
            'message.string' => 'The feedback message must be a string.',
            'message.max' => 'The feedback message may not be greater than 255 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json(['type' => 'error', 'message' => $validator->errors()->first()], 400);
        }

        $feedback = Feedback::create([
            'user_id' => Auth::guard('admin')->id(), // Authenticated admin user's ID
            'member_id' => $request->member_id, // Provided member ID
            'message' => $request->message, // Feedback message
            'read_status' => 'unread', // Default read status
        ]);

        $memberInfo = MemberInfo::where('id', $request->member_id)->first();

        try {
            // Send feedback notification email to the member's organization
            Mail::send('mail.feedback_notification', [
                'organizationName' => $memberInfo->organisation_name,
                'feedbackMessage' => $request->message,
            ], function ($message) use ($memberInfo) {
                $message->to($memberInfo->organisation_email);
                $message->subject('New Feedback Received');
            });

            // Log the feedback sending action
            Helper::log(Auth::guard('admin')->user()->name . " sent feedback to " . $memberInfo->organisation_name);

            return response()->json(['type' => 'success', 'message' => 'Feedback successfully sent and the notification email was sent!']);
        } catch (MailException $e) {
            // If an error occurred while sending the mail
            return response()->json(['type' => 'warning', 'message' => 'Feedback successfully sent, but the notification email could not be sent.']);
        } catch (\Exception $e) {
            // Catch other exceptions
            return response()->json(['type' => 'warning', 'message' => 'Feedback successfully sent, but the notification email could not be sent.']);
        }
    }

    public function memberFeedbackList(Request $request)
    {
        if ($request->ajax()) {
            // Retrieve feedback data along with related user and member
            $feedback = Feedback::where('member_id', $request->member_id)->with(['user', 'member'])->latest();

            return DataTables::of($feedback)
                ->addIndexColumn() // Adds an index column for numbering
                ->addColumn('user_name', function ($row) {
                    return $row->user->name; // Assuming 'name' is a field in the user table
                })
                ->make(true);
        }
        // return view('admin.feedback.index'); // Load the view if the request is not Ajax
    }

    public function memberFeedbackdelete(Request $request)
    {
        $feedback = Feedback::findOrFail($request->id);
        $memberInfo = MemberInfo::where('id', $feedback->member_id)->first();
        $feedback->delete();
        Helper::log(Auth::guard('admin')->user()->name . "Delete  feedbacks of $memberInfo->organisation_name");
        return response()->json(['success' => 'Feedback deleted successfully']);
    }
}
