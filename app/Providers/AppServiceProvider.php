<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Event;
use App\Models\MainContent;
use App\Models\MediaAlbum;
use App\Models\MediaGallery;
use App\Models\Member;
use App\Models\MemberInfo;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\Menu;
use App\Models\Publication;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function ($view) {
            // Fetch all menus with submenus where visibility is 1
            $menus = Menu::with('subMenus', 'page')->Where('visibility', 1)->Where('parent_id', 0)->orderBy('position')->get();

            // Fetch all MainContent records once
            $mainContent = MainContent::pluck('content', 'name')->all();

            // Define default values or fallbacks if content is not found
            $global = [
                'logo' => $mainContent['logo'] ?? 'logo.png',
                'favicon' => $mainContent['favicon'] ?? 'logo.png',
                'website_name' => $mainContent['name'] ?? 'Ingo Forum',
                'short_content' => $mainContent['short_content'] ?? '',
                'facebook' => $mainContent['facebook'] ?? '',
                'linkedin' => $mainContent['linkedin'] ?? '',
                'youtube' => $mainContent['youtube'] ?? '',
                'twitter' => $mainContent['twitter'] ?? '',
                'email' => $mainContent['email'] ?? '',
                'phone' => $mainContent['phone'] ?? '',
                'address' => $mainContent['address'] ?? '',
                'address_embaded' => $mainContent['address_embaded'] ?? '',
            ];
            // Check the current route name
            $currentRouteName = Route::currentRouteName();

            // Conditional logic to add banner data for specific routes
            if ($currentRouteName === 'frontend.index') {
                // Fetch Banner data
                $banners  = Banner::where('status', 1)->get()->map(function ($banner) {
                    $banner->background_color = json_decode($banner->background_color, true);
                    $banner->overlay_color = json_decode($banner->overlay_color, true);
                    $banner->title = json_decode($banner->title, true);
                    $banner->description = json_decode($banner->description, true);
                    $banner->button = json_decode($banner->button, true);
                    $banner->bg_image = json_decode($banner->bg_image, true);
                    $banner->content_image = json_decode($banner->content_image, true);
                    return $banner;
                });

                $global['banner'] = $banners;

                $mainContent = MainContent::where('name', 'aboutus-content')->first();
                if ($mainContent) {
                    $aboutus_content = $mainContent->content;
                    $aboutus = json_decode($aboutus_content);
                    $content = $aboutus->content ?? '';
                    $global['aboutus_content'] = $content;
                } else {
                    // Handle the case where no record is found
                    $global['aboutus_content'] = ''; // or provide a default value
                }

                $features = MainContent::where('name', 'aboutus-feature')->first();
                $featuresArray = [];

                if ($features) {
                    $featuresContent = json_decode($features->content, true);
                    if (isset($featuresContent['feature'])) {
                        foreach ($featuresContent['feature'] as $key => $feature) {
                            // Add a condition to include only features where status is 1
                            if (isset($feature['status']) && $feature['status'] == 1) {
                                $featuresArray[] = [
                                    'title' => $feature['title'] ?? '',
                                    'subtitle' => $feature['subtitle'] ?? '',
                                    'icon' => $feature['icon_name'] ?? '',
                                    'status' => $feature['status'] ?? '',
                                ];
                            }
                        }
                    }
                }
                $global['aboutus_feature'] = $featuresArray;

                $latest_event = Event::with('creator')->where('status', 1)->latest()->first();
                $global['latest_event'] = $latest_event;

                $events = Event::with('creator')->where('status', 1)->latest()->take(3)->get();
                $global['events'] = $events;

                $posts = Post::with(['category', 'subcategory', 'addedBy', 'comments', 'replies', 'totalRead', 'addedBy_member'])
                    ->where('status', 1)
                    ->where(function ($query) {
                        $query->where('approval_status', 1)
                            ->orWhereNull('approval_status');
                    })
                    ->latest()
                    ->take(3) // Limit to 3 posts
                    ->get();

                foreach ($posts as $post) {
                    // Summing up the counts of comments and replies
                    $post->total_comments_and_replies = $post->comments->count() + $post->replies->count();
                    $post->total_reads = $post->totalRead->count();
                }

                $global['posts'] = $posts;

                $publications = Publication::with('addedBy', 'category')->where('status', 1)->take(3)->get();
                $global['publications'] = $publications;


                $albums = MediaAlbum::with([
                    'mediaGalleries' => function ($query) {
                        $query->where('status', 1);
                    },
                    'addedBy' // Include the user relationship
                ])->where('status', 1)->take(3)->get();
                $global['albums'] = $albums;
                $videos = MediaGallery::with('addedBy')->where('type', 'video')->where('status', 1)->latest()->get();
                $global['videos'] = $videos;

                $membersInfos = MemberInfo::with('member')
                    ->whereHas('member', function ($query) {
                        $query->where('status', 1);
                    })
                    ->whereNotNull('logo')
                    ->select('member_id', 'membership_id', 'logo')
                    ->get();
                $global['membersInfos'] = $membersInfos;
            }
            $pendingMemberCount = Member::where('status', 0)->with('memberInfos')->count();
            $global['pendingMemberCount'] = $pendingMemberCount;

            $pendingPostCount = Post::where('approval_status', 0)->count();
            $global['pendingPostCount'] = $pendingPostCount;

            $pendingPublicationCount = Publication::where('approval_status', 0)->count();
            $global['pendingPublicationCount'] = $pendingPublicationCount;

            $pendingEventCount = Event::where('approval_status', 0)->count();
            $global['pendingEventCount'] = $pendingEventCount;
            $view->with(compact('global', 'menus'));
        });
    }
}
