<?php

namespace App\Http\Controllers\Frontend\File;

use App\Http\Controllers\Controller;
use App\Models\FileCategory;
use App\Models\FileNgo;
use App\Models\MemberInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FileController extends Controller
{
    public function memberFileIndex(Request $request)
    {
        if ($request->ajax()) {
            $files = FileNgo::with(['category', 'subcategory', 'creator'])
                ->latest()->where('creator_type', '\App\Models\Member')->where('creator_id', auth()->guard('member')->id())
                ->get();

            return DataTables::of($files)
                ->addColumn('category_name', function ($file) {
                    return $file->category->name ?? 'N/A';
                })
                ->addColumn('subcategory_name', function ($file) {
                    return $file->subcategory->name ?? 'N/A';
                })
                ->addColumn('creator', function ($file) {
                    return $file->creator->name ?? $file->creator->info->organisation_name;
                })
                ->make(true);
        }
        $categories = FileCategory::where('parent_id', 0)
            ->where('status', 1)
            ->with(['subcategories' => function ($query) {
                $query->where('status', 1);
            }])
            ->get();
        $memberId = auth()->guard('member')->id();
        $members = MemberInfo::where('member_id', '!=', $memberId)->get();
        return view('frontend.member.dashboard.partials.file.file-index', compact('categories', 'members'));
    }

    public function memberFileEdit($id)
    {
        return $file = FileNgo::with(['category', 'subcategory', 'creator'])->where('id', $id)->first();
    }

    public function publicfilelist(Request $request)
    {
        if ($request->ajax()) {
            $files = FileNgo::with(['category', 'subcategory', 'creator'])->where('status', 1)
                ->where('assign_to', '0')  // Filter where assign_to is 0
                ->orWhere(function ($query) {
                    $query->where('assign_to', '!=', '0')
                        ->whereRaw('NOT JSON_VALID(assign_to)');  // Ensure it's not a valid JSON
                })
                ->latest()
                ->get();

            return DataTables::of($files)
                ->addColumn('category_name', function ($file) {
                    return $file->category->name ?? 'N/A';
                })
                ->addColumn('subcategory_name', function ($file) {
                    return $file->subcategory->name ?? 'N/A';
                })
                ->addColumn('creator', function ($file) {
                    return $file->creator->name ?? $file->creator->info->organisation_name;
                })
                ->make(true);
        }
        return view('frontend.member.dashboard.partials.file.file-index');
    }
    public function sharedfilelist(Request $request)
    {
        if ($request->ajax()) {
            $memberId = auth()->guard('member')->id();

            $files = FileNgo::with(['category', 'subcategory', 'creator'])
                ->where('status', 1)
                ->where('assign_to', '!=', '0') // Include only assigned
                ->latest()
                ->get();

            $filteredFiles = $files->filter(function ($file) use ($memberId) {
                $assignedMembers = json_decode($file->assign_to, true);
                return in_array($memberId, $assignedMembers);
            });

            $files = $filteredFiles->values(); // Reset keys


            return DataTables::of($files)
                ->addColumn('category_name', function ($file) {
                    return $file->category->name ?? 'N/A';
                })
                ->addColumn('subcategory_name', function ($file) {
                    return $file->subcategory->name ?? 'N/A';
                })
                ->addColumn('creator', function ($file) {
                    return $file->creator->name ?? $file->creator->info->organisation_name;
                })
                ->make(true);
        }
        return view('frontend.member.dashboard.partials.file.file-index');
    }

    public function userManual()
    {
        

        // Pass the file URL to the view
        $fileUrl = asset('public/user-manual/INGO User Manual Frontend.pdf');

        // Return the view with the file URL
        return view('frontend.member.dashboard.partials.user-manual.user-manual', compact('fileUrl'));
    }
}
