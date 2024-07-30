<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\URL as LaravelURL;
use App\Models\Post;
use App\Models\Page;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        // Add static URLs
        $sitemap->add(Url::create(LaravelURL::to('/')));
        
        // Add dynamic URLs for posts
        $posts = Post::where('status', 1)->get();
        foreach ($posts as $post) {
            $sitemap->add(Url::create(route('single.post', ['categorySlug' => $post->category->slug, 'postSlug' => $post->slug]))
                ->setLastModificationDate($post->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8));
        }

        // Add dynamic URLs for pages with visibility set to 1
        $pages = Page::where('visibility', 1)->get();
        foreach ($pages as $page) {
            $sitemap->add(Url::create(route('frontend.static.page', ['slug' => $page->slug]))
                ->setLastModificationDate($page->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8));
        }
        
        return $sitemap->toResponse(request());
    }
}
