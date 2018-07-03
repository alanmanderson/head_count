<?php
namespace Alanmanderson\HeadCount\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Alanmanderson\HeadCount\Services\UsPhoneNumberHandler;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('PhoneNumberHandler', function ($app) {
            return new UsPhoneNumberHandler();
        });
    }
}
