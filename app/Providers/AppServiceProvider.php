<?php

namespace App\Providers;

use App\Contracts\RandomUserContract;
use App\Services\RandomUserMe\RandomUserMeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RandomUserContract::class, RandomUserMeService::class);
    }
}
