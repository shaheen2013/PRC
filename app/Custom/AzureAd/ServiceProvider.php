<?php

namespace App\Custom\AzureAd;

use Illuminate\Support\Facades\Auth;
use App\Custom\AzureAd\Middleware\Authenticate;
use SocialiteProviders\Manager\SocialiteWasCalled;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        // $this->app->bind('azure-user', function(){
        //     return new AzureUser(
        //         session('azure_user')
        //     );
        // });
    }

    public function boot()
    {
        // Auth::extend('azure', function(){
        //     dd('test');
        //     return new Authenticate();
        // });

        $this->publishes([
            __DIR__.'/config/azure-oath.php' => config_path('azure-oath.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/config/azure-oath.php', 'azure-oath'
        );

        $this->app['Laravel\Socialite\Contracts\Factory']->extend('azure-oauth', function ($app) {
            return $app['Laravel\Socialite\Contracts\Factory']->buildProvider(
                \App\Custom\AzureAd\AzureOauthProvider::class,
                config('azure-oath.credentials')
            );
        });

        $this->app['router']->group(['middleware' => config('azure-oath.routes.middleware')], function ($router) {
            $router->get(config('azure-oath.routes.login'), 'App\Custom\AzureAd\AuthController@redirectToOauthProvider');
            $router->get(config('azure-oath.routes.callback'), 'App\Custom\AzureAd\AuthController@handleOauthResponse');
        });
    }
}
