<?php

namespace App\Policies;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function attachUser($user, $role)
    {
        return $user->can('manageRoles', $role);
    }

    public function viewAny($user)
    {
        return Gate::any(['viewRoles', 'manageRoles'], $user);
    }

    public function view($user, $role)
    {
        return Gate::any(['viewRoles', 'manageRoles'], $user, $role);
    }

    public function create($user)
    {
        return $user->can('manageRoles');
    }

    public function update($user, $role)
    {
        return $user->can('manageRoles', $role);
    }

    public function delete($user, $role)
    {
        return $user->can('manageRoles', $role);
    }

    public function restore($user, $role)
    {
        return $user->can('manageRoles', $role);
    }

    public function forceDelete($user, $role)
    {
        return $user->can('manageRoles', $role);
    }
}
