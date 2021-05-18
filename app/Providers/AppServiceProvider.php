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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);

        /* Configuração Braintree */
        /*$environment = config('app.braintree_env');
        $braintree = new \Braintree\Gateway([
            'environment' => config('app.braintree_env'),
            'merchantId' => config('app.braintree_merchant_id'),
            'publicKey' => config('app.braintree_public_key'),
            'privateKey' => config('app.braintree_private_key')
        ]);
        config(['braintree' => $braintree]);*/
    }
}
