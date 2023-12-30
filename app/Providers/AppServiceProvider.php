<?php

namespace App\Providers;

use App\Services\Telegram\TelegramServices;
use App\Services\Time\TimeServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->facade();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }

    public function facade()
    {
        $this->app->bind('time', TimeServices::class);
        $this->app->bind('Telegram', TelegramServices::class);
    }
}
