<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Yajra\DataTables\DataTables;
use Validator;

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
            $data = Page::select(['id', 'title', 'slug', 'visibility'])->orderBy('id', 'DESC');
            return DataTables::of($data)
                ->addColumn('actions', function($row){
                    return '<a href="'.route('page.edit', $row->id).'" id="edit-page-button"><i class="fas fa-edit text-success"></i></a>&nbsp;<i class="fas fa-trash-alt text-danger" id="delete-page" data="'.$row->id.'"></i>';
                })
                ->addColumn('status', function($row){
                    // Use the url() helper to generate the full URL
                    $pageUrl = url($row->slug);
                    return $row->visibility 
                        ? '<i class="fas fa-eye text-primary" id="inactive-page" data="'.$row->id.'"></i>&nbsp;<a href="'.$pageUrl.'" target="_blank"><i class="fas fa-external-link-alt text-info"></i></a>'
                        : '<i class="fas fa-eye-slash" id="active-page" data="'.$row->id.'"></i>';
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
        }

        return view('admin.content.page.index');
    }

    public function storeOrUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page_title' => 'required|string|max:255',
            'page_slug' => 'required|string|max:255|unique:pages,slug,' . $request->page_id,
            'page_details' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        if ($request->page_id) {
            // Update existing page
            $page = Page::findOrFail($request->page_id);
            $page->update([
                'title' => $request->page_title,
                'slug' => $request->page_slug,
                'details' => $request->page_details,
            ]);

            return response()->json(['message' => 'Page updated successfully']);
        } else {
            // Store new page
            Page::create([
                'title' => $request->page_title,
                'slug' => $request->page_slug,
                'details' => $request->page_details,
            ]);

            return response()->json(['message' => 'Page created successfully']);
        }

        return response()->json(['message' => 'Operation successful']);
    }

    // Edit page
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return response()->json($page);
    }

    public function verifySlug(Request $request)
    {
        $slug = $request->input('slug');
        $exists = Page::where('slug', $slug)->exists();
        return response()->json(['exists' => $exists]);
    }
    
    public function toggleVisibility(Request $request)
    {
        $page = Page::findOrFail($request->id);
        $page->visibility = !$page->visibility;
        $page->save();

        return response()->json(['message' => 'Page visibility updated successfully', 'visibility' => $page->visibility]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pages,id'
        ]);

        $page = Page::find($request->id);
        $page->delete();

        return response()->json([
            'message' => 'Page has been deleted successfully.'
        ]);
    }

}
