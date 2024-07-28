<?php

namespace App\Http\Controllers\Frontend\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class PageController extends Controller
{
    public function show($slug)
    {
        // Fetch the page by slug
        $page = Page::where('slug', $slug)->where('visibility', 1)->first();

        // Check if page exists and is visible
        if (!$page) {
            abort(404); // Page not found
        }

        // Generate keywords from the description
        $description = strip_tags($page->details);
        $keywords = $this->generateKeywords($description);

        // Set SEO meta tags
        SEOMeta::setTitle($page->title);
        SEOMeta::setDescription(substr(strip_tags($page->details), 0, 200)); // Set description from page details
        SEOMeta::addMeta('article:published_time', $page->created_at->toW3CString(), 'property');
        SEOMeta::addKeyword($keywords); // Add relevant keywords

        OpenGraph::setDescription(substr(strip_tags($page->details), 0, 200));
        OpenGraph::setTitle($page->title);
        OpenGraph::setUrl(route('frontend.static.page', ['slug' => $page->slug]));
        OpenGraph::addProperty('type', 'article');
        // OpenGraph::addImage(asset("public/frontend/images/pages/{$page->header_image}")); // Make sure the image path is correct

        TwitterCard::setTitle($page->title);
        TwitterCard::setSite('@your_twitter_handle'); // Replace with your Twitter handle
        TwitterCard::setDescription(substr(strip_tags($page->details), 0, 160));
        // TwitterCard::setImage(asset("public/frontend/images/pages/{$page->header_image}"));

        JsonLd::setTitle($page->title);
        JsonLd::setDescription(substr(strip_tags($page->details), 0, 160));
        JsonLd::setType('Article');
        // JsonLd::addImage(asset("public/frontend/images/pages/{$page->header_image}"));

        return view('frontend.page.static.static-page', compact('page'));
    }

    public function becomeMember()
    {
        return view('frontend.member.become-member');
    }

    private function generateKeywords($text)
    {
        // Define a list of common stop words
        $stopWords = [
            'i', 'me', 'my', 'myself', 'we', 'our', 'ours', 'ourselves', 'you', 'your', 'yours', 'yourself', 'yourselves',
            'he', 'him', 'his', 'himself', 'she', 'her', 'hers', 'herself', 'it', 'its', 'itself', 'they', 'them', 'their',
            'theirs', 'themselves', 'what', 'which', 'who', 'whom', 'this', 'that', 'these', 'those', 'am', 'is', 'are', 
            'was', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'having', 'do', 'does', 'did', 'doing', 'a', 'an', 
            'the', 'and', 'but', 'if', 'or', 'because', 'as', 'until', 'while', 'of', 'at', 'by', 'for', 'with', 'about', 
            'against', 'between', 'into', 'through', 'during', 'before', 'after', 'above', 'below', 'to', 'from', 'up', 
            'down', 'in', 'out', 'on', 'off', 'over', 'under', 'again', 'further', 'then', 'once', 'here', 'there', 'when', 
            'where', 'why', 'how', 'all', 'any', 'both', 'each', 'few', 'more', 'most', 'other', 'some', 'such', 'no', 
            'nor', 'not', 'only', 'own', 'same', 'so', 'than', 'too', 'very', 's', 't', 'can', 'will', 'just', 'don', 
            'should', 'now'
        ];

        // Convert the description to lowercase and split into words
        $words = explode(' ', strtolower($text));

        // Filter out the stop words
        $keywords = array_diff($words, $stopWords);

        // Return the first 10 keywords
        return array_slice($keywords, 0, 10);
    }
}
