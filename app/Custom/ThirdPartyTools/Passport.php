<?php

namespace App\Custom\ThirdPartyTools;

//use Kristories\Novassport\Novassport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class Passport  //extends Novassport
{
    use HandlesAuthorization;

    public function renderNavigation()
    {
        if (Auth::user()->can('viewTools')) {
            return view('novassport::navigation');
        } else {
            return false;
        }
    }
}
