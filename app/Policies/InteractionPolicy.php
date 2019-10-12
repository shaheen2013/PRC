<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class InteractionPolicy
{
    use HandlesAuthorization;

    public function viewAny($user)
    {
        return Gate::any(['viewInteraction', 'manageInteraction'], $user);
    }

    public function view($user, $interaction)
    {
        return Gate::any(['viewInteraction', 'manageInteraction'], $user, $interaction);
    }

    public function create($user)
    {
        return $user->can('manageInteraction');
    }

    public function update($user, $interaction)
    {
        if ($user->id == $interaction->user_id) {
            return $user->can('viewInteraction', $interaction);
        } else {
            return $user->can('manageInteraction', $interaction);
        }
    }

    public function delete($user, $interaction)
    {
        return $user->can('manageInteraction', $interaction);
    }

    public function restore($user, $interaction)
    {
        return $user->can('manageInteraction', $interaction);
    }

    public function forceDelete($user, $interaction)
    {
        return $user->can('manageInteraction', $interaction);
    }
}
