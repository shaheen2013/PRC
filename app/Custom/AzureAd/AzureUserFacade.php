<?php

namespace App\Custom\AzureAd;

use Illuminate\Support\Facades\Facade;

class AzureUserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'azure-user';
    }
}
