<?php

namespace App\Providers;

use App\Models\LearningArtifact;
use App\Observers\LearningArtifactObserver;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        LearningArtifact::observe(LearningArtifactObserver::class);

//        Filament::serving(function () {
//            Filament::registerTheme(mix('css/app.css'));
//        });
    }
}
