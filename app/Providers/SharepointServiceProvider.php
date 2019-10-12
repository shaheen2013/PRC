<?php

namespace App\Providers;

use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use DelaneyMethod\FlysystemSharepoint\SharepointAdapter;
use DelaneyMethod\Sharepoint\Client as SharepointClient;

class SharepointServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('sharepoint', function ($app, $config) {
            $client = new SharepointClient(
                $config['siteName'],
                $config['siteUrl'],
                $config['publicUrl'],
                $config['clientId'],
                $config['clientSecret'],
                $config['verify'],
                $config['accessToken']
            );

            return new Filesystem(new SharepointAdapter($client));
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
