<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\InsurancePolicyRepositoryInterface;
use App\Repositories\InsurancePolicyRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(InsurancePolicyRepositoryInterface::class, InsurancePolicyRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
