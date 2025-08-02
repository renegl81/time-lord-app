<?php

namespace App\Providers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        $locale = app()->getLocale();
        $translations = [];

        // Cargar traducciones desde archivos JSON
        if (File::exists(resource_path("lang/{$locale}.php"))) {
            $translations = include resource_path("lang/es.php");
        }

        Inertia::share([
            'locale' => $locale,
            'translations' => $translations,
        ]);
    }
}
