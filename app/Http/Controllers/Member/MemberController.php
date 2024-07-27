<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MemberController extends Controller
{
    public function memberlist(Request $request)
    {
        // return $members = Member::where('status', 0)->with('memberInfos')->get();
        if ($request->ajax()) {
            $organizationType = $request->organization;
            $statusFilter = $request->status_filter;
            $members = Member::with('memberInfos')->get();
            // If organization type is provided, filter the members
            if (!empty($organizationType)) {
                $members = $members->filter(function($member) use ($organizationType) {
                    return $member->memberInfos->first() && $member->memberInfos->first()->organisation_type == $organizationType;
                });
            }
            if ($statusFilter !== null && $statusFilter !== '') {
                $members = $members->filter(function($member) use ($statusFilter) {
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
                ->addColumn('org_type', function ($member) {
                    return optional($member->memberInfos->first())->organisation_type ?? 'N/A';
                })
                ->make(true);
        }
        return view('admin.member.member-list');
    }
    public function memberRequest(Request $request)
    {
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
                ->addColumn('org_type', function ($member) {
                    return optional($member->memberInfos->first())->organisation_type ?? 'N/A';
                })
                ->make(true);
        }
        return view('admin.member.member-request');
    }

    public function view($id)
    {
        $member = Member::where('id', $id)->with('memberInfos')->first();

        return view('admin.member.member-view', compact('member'));
    }
    public function approved(Request $request)
    {
        // Find the member by ID
        $member = Member::with('memberInfos')->findOrFail($request->id);
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
            $newMembershipId = 'AF-05-04-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Update the memberInfo with the new membership_id
            $memberInfo = $member->memberInfos[0];
            $memberInfo->membership_id = $newMembershipId;
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

        // Return JSON response with success message and rendered partial views
        return response()->json([
            'success' => 'Member Approved successfully',
            'viewHeader' => $viewHeader,
            'profileImageName' => $profileImageName
        ]);
    }
    public function suspend(Request $request)
    {
        // Find the member by ID
        $member = Member::findOrFail($request->id);

        // Update the status to 1 (or any appropriate value for "suspended")
        $member->status = 2; // Assuming 1 means suspended status

        // Save the changes
        $member->save();
        // Render view-header.blade.php
        $viewHeader = view('admin.member.partials.view-header', compact('member'))->render();

        // Render profile-image-name.blade.php (assuming $profileImageName is available in your context)
        $profileImageName = view('admin.member.partials.profile-image-name', compact('member'))->render();

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
        // Find the member by ID
        $member = Member::findOrFail($request->id);

        // Update the status to 1 (or any appropriate value for "suspended")
        $member->status = 3; // Assuming 1 means suspended status

        // Save the changes
        $member->save();
        // Render view-header.blade.php
        $viewHeader = view('admin.member.partials.view-header', compact('member'))->render();

        // Render profile-image-name.blade.php (assuming $profileImageName is available in your context)
        $profileImageName = view('admin.member.partials.profile-image-name', compact('member'))->render();

        // Return JSON response with success message and rendered partial views
        return response()->json([
            'success' => 'Member Approved successfully',
            'viewHeader' => $viewHeader,
            'profileImageName' => $profileImageName
        ]);
    }
}
