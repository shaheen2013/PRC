<?php

namespace App\Custom\ThirdPartyTools;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
use Christophrumpel\NovaNotifications\NovaNotifications;

class Notifications extends NovaNotifications
{
    use HandlesAuthorization;

    public function renderNavigation()
    {
        if (Auth::user()->can('viewTools')) {
            return view('nova-notifications::navigation');
        } else {
            return false;
        }
    }
}
