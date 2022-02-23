<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
<<<<<<< HEAD
        //
=======

            $this->app->bind('path.public',function(){
            return'/home/todosytodasaestu/public_html';

        });
>>>>>>> b3fdd3a8926829fa2e7fbc1d8084f322512e2b5c
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
