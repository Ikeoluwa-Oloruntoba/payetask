<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FetchArticleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('FetchArticle', function ($app) {
            return new FetchArticleService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
