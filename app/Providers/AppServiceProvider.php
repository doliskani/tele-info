<?php

namespace App\Providers;

use App\Repository\BaseRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\Persone\NavaRepository;
use App\Repository\Persone\NavaRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(NavaRepositoryInterface::class, NavaRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
