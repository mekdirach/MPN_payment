<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\QueryService\QueryService;
use Illuminate\Support\Facades\URL;

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
        if (in_array(config('app.env'), ['staging', 'production'])) {
            URL::forceScheme('https');
        }

        $this->app->bind('query_service', function () {
            return new QueryService();
        });
    }
}
