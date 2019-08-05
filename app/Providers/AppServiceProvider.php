<?php

namespace App\Providers;

use App\User\PhoneNumberService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

use Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            $phone  = new PhoneNumberService();
            return (bool)$phone->standardPhone($value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/../Http/helpers.php';
    }
}
