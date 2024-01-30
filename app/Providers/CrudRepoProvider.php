<?php

namespace App\Providers;

use App\Http\Controllers\ClientOrderController;
use App\Interfaces\CrudRepoInterface;
use App\Repositories\ClientOrderRepository;
use Illuminate\Support\ServiceProvider;

class CrudRepoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(ClientOrderController::class)
          ->needs(CrudRepoInterface::class)
          ->give(function () {
              return new ClientOrderRepository();
          });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
