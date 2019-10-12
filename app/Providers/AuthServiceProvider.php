<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Contact;
use App\Models\CMCommunity;
use App\Models\Interaction;
use App\Models\Organization;
use Laravel\Passport\Passport;
use Silvanite\Brandenburg\Role;
use Illuminate\Support\Facades\Gate;
use Silvanite\Brandenburg\Traits\ValidatesPermissions;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use ValidatesPermissions;

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Contact::class => \App\Policies\ContactPolicy::class,
        Interaction::class => \App\Policies\InteractionPolicy::class,
        CMCommunity::class => \App\Policies\CommunityPolicy::class,
        Organization::class => \App\Policies\OrganizationPolicy::class,
        User::class => \App\Policies\UserPolicy::class,
        Role::class => \App\Policies\RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        collect([
            'viewInteraction',
            'manageInteraction',
            'viewContact',
            'manageContact',
            'viewCommunity',
            'manageCommunity',
            'viewOrganization',
            'manageOrganization',
            'viewTools',
        ])->each(function ($permission) {
            Gate::define($permission, function ($user) use ($permission) {
//                if ($this->nobodyHasAccess($permission)) {
//                    return true;
//                }

                return $user->hasRoleWithPermission($permission);
            });
        });

        $this->registerPolicies();
        Passport::routes();
    }
}
