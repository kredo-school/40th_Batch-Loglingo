<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Relation::morphMap([
            'App\Models\Post' => \App\Models\Post::class,
            'App\Models\Question' => \App\Models\Question::class,
            'App\Models\Discussion' => \App\Models\Discussion::class,
        ]);

        view()->composer('*', function ($view) {
            if (Auth::check()) {
                Auth::user()->loadCount(['posts', 'questions', 'discussions']);
            }
        });
    }
}
