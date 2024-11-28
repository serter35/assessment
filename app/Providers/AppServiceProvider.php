<?php

namespace App\Providers;

use App\Contract\Messaging\ClientContract;
use App\Contract\Messaging\RecipientRepositoryContract;
use App\Contract\Messaging\RecipientServiceContract;
use App\Repositories\RecipientRepository;
use App\Services\Messaging\Client;
use App\Services\Messaging\RecipientService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            ClientContract::class,
            fn() => new Client(
                $this->app->make('config')->get('services.messaging.url')
            )
        );
        $this->app->singleton(RecipientServiceContract::class, RecipientService::class);
        $this->app->singleton(RecipientRepositoryContract::class, RecipientRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
