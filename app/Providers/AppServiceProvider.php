<?php

namespace App\Providers;

use App\Models\MainContent;
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

            $view->with('global', $global);
        });
    }
}
