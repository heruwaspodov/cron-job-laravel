<?php

namespace App\Providers;

use App\Models\User;
use App\Services\DailyCalculateService;
use App\Services\FetchUsersService;
use App\Services\HourlyCalculateService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('FetchUserServiceInterface:FetchUsersService', function ($app) {
            return new FetchUsersService();
        });
        $this->app->bind('DefaultServiceInterface:DailyCalculate', function ($app) {
            return new DailyCalculateService();
        });
        $this->app->bind('DefaultServiceInterface:HourlyCalculate', function ($app) {
            return new HourlyCalculateService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Trigger after delete record User.
         */
        User::deleted(function (User $model) {
            $service = app()->make('DefaultServiceInterface:HourlyCalculate');
            $service->call();
        });
    }
}
