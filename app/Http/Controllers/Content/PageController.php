<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Page::select(['id', 'title', 'slug', 'visibility']);
            return DataTables::of($data)
                ->addColumn('actions', function($row){
                    return '<a href="'.route('pages.edit', $row->id).'" class="btn btn-primary">Edit</a>';
                })
                ->addColumn('status', function($row){
                    return $row->visibility ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
        }

        return view('admin.content.page.index');
    }
    
    public function verifySlug(Request $request)
    {
        $slug = $request->input('slug');
        $exists = Page::where('slug', $slug)->exists();
        return response()->json(['exists' => $exists]);
    }
    
}
