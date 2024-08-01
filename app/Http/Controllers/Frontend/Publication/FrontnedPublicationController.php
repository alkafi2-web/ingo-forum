<?php

namespace App\Http\Controllers\Frontend\Publication;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\PublicationCategory;
use Illuminate\Http\Request;

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
}
