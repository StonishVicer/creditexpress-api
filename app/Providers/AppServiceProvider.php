<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Eloquent\CustomerRepository;

use App\Repositories\Contracts\LoanRepositoryInterface;
use App\Repositories\Eloquent\LoanRepository;

use App\Repositories\Contracts\LoanStatusRepositoryInterface;
use App\Repositories\Eloquent\LoanStatusRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(LoanRepositoryInterface::class, LoanRepository::class);
        $this->app->bind(LoanStatusRepositoryInterface::class, LoanStatusRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
