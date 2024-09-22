<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;


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
        //
        Schema::defaultStringLength(191);
        Http::macro('withAuthProxy', function () {
            return Http::withOptions([
                'proxy' => [
                    'http'  => 'http://root:fTmN6i7T@103.114.104.174:30316',
                    'https' => 'http://root:fTmN6i7T@103.114.104.174:30316',
                ],
                'timeout' => 30,
            ]);
        });
    }
}
