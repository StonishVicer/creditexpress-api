<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\CustomersRepositoryInterface;
use App\Repositories\Eloquent\CustomersRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CustomersRepositoryInterface::class, CustomersRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
