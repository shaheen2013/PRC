<?php

namespace App\Policies;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommunityPolicy
{
    use HandlesAuthorization;

    public function addContact($user, $community)
    {
        return $user->can('manageCommunity', $community);
    }

    public function viewAny($user)
    {
        return Gate::any(['viewInteraction', 'manageCommunity'], $user);
    }

    public function view($user, $community)
    {
        return Gate::any(['viewInteraction', 'manageCommunity'], $user, $community);
    }

    public function create($user)
    {
        return false;
    }

    public function update($user, $community)
    {
        return $user->can('manageCommunity', $community);
    }

    public function delete($user, $community)
    {
        return false;
    }

    public function restore($user, $community)
    {
        return $user->can('manageCommunity', $community);
    }

    public function forceDelete($user, $community)
    {
        return $user->can('manageCommunity', $community);
    }
}
