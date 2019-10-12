<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    public function addContact($user, $organization)
    {
        return $user->can('manageOrganization', $organization);
    }

    public function viewAny($user)
    {
        return Gate::any(['viewOrganization', 'manageOrganization'], $user);
    }

    public function view($user, $organization)
    {
        return Gate::any(['viewOrganization', 'manageOrganization'], $user, $organization);
    }

    public function create($user)
    {
        return $user->can('manageOrganization');
    }

    public function update($user, $organization)
    {
        return $user->can('manageOrganization', $organization);
    }

    public function delete($user, $organization)
    {
        return $user->can('manageOrganization', $organization);
    }

    public function restore($user, $organization)
    {
        return $user->can('manageOrganization', $organization);
    }

    public function forceDelete($user, $organization)
    {
        return $user->can('manageOrganization', $organization);
    }
}
