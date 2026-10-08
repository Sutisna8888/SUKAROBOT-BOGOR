<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        view()->composer([
            'client.partials.navbar',
            'client.layouts.dashboard',
        ], function ($view): void {
            $unreadNotificationCount = Auth::check()
                ? DB::table('notifications')
                    ->where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count()
                : 0;

            $view->with('unreadNotificationCount', $unreadNotificationCount);
        });
    }
}
