<?php

namespace App\Policies;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
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

    public function addInteraction($user, $contact)
    {
        return $user->can('manageContact', $contact);
    }

    public function viewAny($user)
    {
        return Gate::any(['viewContact', 'manageContact'], $user);
    }

    public function view($user, $contact)
    {
        return Gate::any(['viewContact', 'manageContact'], $user, $contact);
    }

    public function create($user)
    {
        return $user->can('manageContact');
    }

    public function update($user, $contact)
    {
        return $user->can('manageContact', $contact);
    }

    public function delete($user, $contact)
    {
        return $user->can('manageContact', $contact);
    }

    public function restore($user, $contact)
    {
        return $user->can('manageContact', $contact);
    }

    public function forceDelete($user, $contact)
    {
        return $user->can('manageContact', $contact);
    }
}
