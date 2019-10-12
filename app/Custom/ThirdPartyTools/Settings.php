<?php

namespace App\Custom\ThirdPartyTools;

//use Cendekia\SettingTool\SettingTool;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class Settings  //extends SettingTool
{
    use HandlesAuthorization;

    public function renderNavigation()
    {
        if (Auth::user()->can('viewTools')) {
            return view('setting-tool::navigation');
        } else {
            return false;
        }
    }
}
