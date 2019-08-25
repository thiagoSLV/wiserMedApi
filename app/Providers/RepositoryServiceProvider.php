<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\PacientRepository::class, \App\Repositories\PacientRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DoctorRepository::class, \App\Repositories\DoctorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AppointmentRepository::class, \App\Repositories\AppointmentRepositoryEloquent::class);
        //:end-bindings:
    }
}
