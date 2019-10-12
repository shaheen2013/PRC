<?php

namespace App\Custom\ThirdPartyTools;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

//use Strandafili\NovaInstalledPackages\Tool;

class NovaInstalledPackages
    //extends Tool
{
    use HandlesAuthorization;

    public function renderNavigation()
    {
        if (Auth::user()->can('viewTools')) {
            return view('nova-installed-packages::navigation');
        } else {
            return false;
        }
    }
}
