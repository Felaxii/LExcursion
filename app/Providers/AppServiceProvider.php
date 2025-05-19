<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Livewire\CityRecommendationsComponent;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return Client::factory();
        });
    }

    public function boot(): void
    {
        Livewire::component('city-recommendations-component', CityRecommendationsComponent::class);

        Route::pushMiddlewareToGroup('web', \App\Http\Middleware\SetLocale::class);
    }
}
