<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Event;
use App\Models\MainContent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
            // Fetch all MainContent records once
            $mainContent = MainContent::pluck('content', 'name')->all();

            // Define default values or fallbacks if content is not found
            $global = [
                'logo' => $mainContent['logo'] ?? '',
                'website_name' => $mainContent['name'] ?? '',
                'short_content' => $mainContent['short_content'] ?? '',
                'facebook' => $mainContent['facebook'] ?? '',
                'linkedin' => $mainContent['linkedin'] ?? '',
                'youtube' => $mainContent['youtube'] ?? '',
                'twitter' => $mainContent['twitter'] ?? '',
                'email' => $mainContent['email'] ?? '',
                'phone' => $mainContent['phone'] ?? '',
            ];
            // Check the current route name
            $currentRouteName = Route::currentRouteName();

            // Conditional logic to add banner data for specific routes
            if ($currentRouteName === 'frontend.index') {
                // Fetch Banner data
                $banners  = Banner::where('status', 1)->get();
                $global['banner'] = $banners;

                $mainContent  = MainContent::where('name', 'aboutus-content')->first();
                $aboutus_content = $mainContent->content;
                $aboutus = json_decode($aboutus_content);
                $content = $aboutus->content;
                $global['aboutus_content'] = $content;

                $features = MainContent::where('name', 'aboutus-feature')->first();
                $featuresContent = json_decode($features->content, true);
                $featuresArray = [];

                if (isset($featuresContent['feature'])) {
                    foreach ($featuresContent['feature'] as $key => $feature) {
                        $featuresArray[] = [
                            'title' => $feature['title'],
                            'subtitle' => $feature['subtitle'],
                            'icon' => $feature['icon_name'],
                            'status' => $feature['status'],
                        ];
                    }
                }
                $global['aboutus_feature'] = $featuresArray;

                $latest_event = Event::where('status',1)->latest()->first();
                $global['latest_event'] = $latest_event;

            }
            $view->with('global', $global);
        });
    }
}
