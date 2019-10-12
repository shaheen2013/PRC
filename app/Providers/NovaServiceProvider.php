<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use App\Models\CMCommunity;
use Jobcerto\NovaGrid\NovaGrid;
use KABBOUCHI\LogsTool\LogsTool;
use Laravel\Nova\Events\ServingNova;
use MadWeb\NovaHorizonLink\HorizonLink;
use App\Custom\ThirdPartyTools\Telescope;
use Bolechen\NovaActivitylog\NovaActivitylog;
use Laravel\Nova\NovaApplicationServiceProvider;
use Prochamps\CommunityDashboard\CommunityDashboard;
use Silvanite\NovaToolPermissions\NovaToolPermissions;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::provideToScript([
                'clickableRow' => [
                    'event' => 'dblclick', // click or dblclick
                    'action' => 'view', // view or edit
                ],
            ]);
        });

        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes();
        //->withPasswordResetRoutes();
                //->register()
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        //
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new CommunityDashboard(),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new NovaActivitylog(),
            new LogsTool(),
            new NovaToolPermissions(),
            new Telescope(),
            new HorizonLink,
            new NovaGrid,
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
