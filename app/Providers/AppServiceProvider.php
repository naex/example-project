<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Repositories\EventRepositoryInterface;
use App\Http\Repositories\Eloquent\EventRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }

    private function registerRepositories(): void
    {
        $this->app->singleton(EventRepositoryInterface::class, EventRepository::class);
    }
}
