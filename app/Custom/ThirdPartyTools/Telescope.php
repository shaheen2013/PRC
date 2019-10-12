<?php

namespace App\Custom\ThirdPartyTools;

use MadWeb\NovaTelescopeLink\TelescopeLink;
use Illuminate\Auth\Access\HandlesAuthorization;

class Telescope extends TelescopeLink
{
    use HandlesAuthorization;

    public function renderNavigation()
    {
        if (auth()->user()->can('viewTools')) {
            return view('nova-telescope-link::navigation');
        } else {
            return false;
        }
    }
}
