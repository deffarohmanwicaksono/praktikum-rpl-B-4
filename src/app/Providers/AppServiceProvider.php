<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer(['layouts.sidebar', 'layouts.topbar'], function ($view) {
            $unreadCount = 0;
            if (\Illuminate\Support\Facades\Auth::check()) {
                $unreadCount = \App\Models\Notification::where('user_id', \Illuminate\Support\Facades\Auth::id())
                                ->where('is_read', false)
                                ->count();
            }
            $view->with('unreadCount', $unreadCount);
        });
    }
}
