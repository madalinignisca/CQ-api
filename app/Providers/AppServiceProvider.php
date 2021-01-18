<?php

namespace App\Providers;


use App\Jobs\ProcessPhotoStoring;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
