<?php

namespace App\Http\Controllers\Frontend\File;

use App\Http\Controllers\Controller;
use App\Models\FileCategory;
use App\Models\FileNgo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FileController extends Controller
{
    public function memberFileIndex(Request $request)
    {
        if ($request->ajax()) {
            $files = FileNgo::with(['category', 'subcategory', 'creator'])
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
        $categories = FileCategory::where('parent_id', 0)
            ->where('status', 1)
            ->with(['subcategories' => function ($query) {
                $query->where('status', 1);
            }])
            ->get();
        return view('frontend.member.dashboard.partials.file.file-index',compact('categories'));
    }

    public function memberFileEdit($id){
        return $file = FileNgo::with(['category', 'subcategory', 'creator'])->where('creator_type','\App\Models\Member')->where('creator_id',Auth::guard('member')->id())->first();
    }
}
