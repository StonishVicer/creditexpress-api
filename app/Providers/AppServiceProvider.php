<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\CustomersRepositoryInterface;
use App\Repositories\Eloquent\CustomersRepository;

use App\Repositories\Contracts\LoansRepositoryInterface;
use App\Repositories\Eloquent\LoansRepository;

use App\Repositories\Contracts\LoansStatusRepositoryInterface;
use App\Repositories\Eloquent\LoansStatusRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CustomersRepositoryInterface::class, CustomersRepository::class);
        $this->app->bind(LoansRepositoryInterface::class, LoansRepository::class);
        $this->app->bind(LoansStatusRepositoryInterface::class, LoansStatusRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
