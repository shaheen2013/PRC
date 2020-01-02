<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function delete($user, $project)
    {
        return false;
    }
    public function view($user, $community)
    {
        return true;
    }
}
