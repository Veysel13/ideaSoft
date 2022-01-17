<?php


namespace App\Providers;


use App\Repository\OrderInterface;
use App\Repository\OrderRepository;
use App\Repository\ProductInterface;
use App\Repository\ProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            OrderInterface::class,
            OrderRepository::class
        );

        $this->app->bind(
            ProductInterface::class,
            ProductRepository::class
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
