<?php

namespace App\Policies;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function attachRole($user)
    {
        return $user->can('manageUsers', $user);
    }

    public function viewAny($user)
    {
        return Gate::any(['viewUsers', 'manageUsers'], $user);
    }

    public function view($user)
    {
        return Gate::any(['viewUsers', 'manageUsers'], $user, $user);
    }

    public function create($user)
    {
        return $user->can('manageUsers');
    }

    public function update($user)
    {
        return $user->can('manageUsers', $user);
    }

    public function delete($user)
    {
        return $user->can('manageUsers', $user);
    }

    public function restore($user)
    {
        return $user->can('manageUsers', $user);
    }

    public function forceDelete($user)
    {
        return $user->can('manageUsers', $user);
    }
}
