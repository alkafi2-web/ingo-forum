<?php

namespace App\Http\Controllers\Frontend\Publication;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\PublicationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FrontnedPublicationController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->input('category');
        $author = $request->input('author');
        $publisher = $request->input('publisher');
        $searchTerm = $request->input('search');

        $query = Publication::with('addedBy', 'category')->where('status', 1);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($author) {
            $query->where('author', $author);
        }

        if ($publisher) {
            $query->where('publisher', $publisher);
        }

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('short_description', 'like', "%{$searchTerm}%")
                    ->orWhere('author', 'like', "%{$searchTerm}%")
                    ->orWhere('publisher', 'like', "%{$searchTerm}%")
                ;
            });
        }

        $publications = $query->latest()->paginate(9);

        if ($request->ajax()) {
            $html = view('frontend.publication.partials.publication_partials', compact('publications'))->render();
            $pagination = $publications->links()->render();
            return response()->json(['html' => $html, 'pagination' => $pagination]);
        }

        $categories = PublicationCategory::where('status', 1)->get();
        $authorsAndPublishers = Publication::select('author', 'publisher')->distinct()->get();

        return view('frontend.publication.publication', compact('publications', 'categories', 'authorsAndPublishers'));
    }

    public function memberPublicationIndex(Request $request) {
        if ($request->ajax()) {
            $publication = Publication::with('addedBy', 'category','addedBy_member')->where('member_id',Auth::guard('member')->id())->latest();
            // Format data for DataTables
            return DataTables::of($publication)
                ->addColumn('category_name', function ($publication) {
                    return $publication->category->name;
                })
                ->addColumn('added_by', function ($publication) {
                    return $publication->addedBy->name ?? $publication->addedBy_member->organisation_name ?? null;
                })
                ->make(true);
        }
        $categories = PublicationCategory::where('status',1)->get();
        return view('frontend.member.dashboard.partials.publication.publication-index',compact('categories'));
    }

    public function memberPublicationEdit($id){
        return $publication = Publication::with('addedBy', 'category','addedBy_member')->where('member_id',Auth::guard('member')->id())->first();
    }


}
