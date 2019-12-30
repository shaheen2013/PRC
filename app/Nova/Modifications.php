<?php

namespace App\Nova;

use App\Approval;
use App\Disapproval;
use App\Models\User;
use NovaButton\Button;
use App\Models\OptInStatus;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use App\Models\OnboardingStatus;
use Laravel\Nova\Fields\DateTime;
use App\Models\ViolationConfiguration;
use App\Models\RentalVacantSalesStatus;
use App\Nova\Filters\ChangeRequestStatus;
use App\Models\CommunitySalesConfiguration;
use Laravel\Nova\Http\Requests\NovaRequest;
use Saumini\EllipsisTextarea\EllipsisTextarea;

class Modifications extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Modification::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return $query->where('active', 0);
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function label()
    {
        return 'Change Requests';
    }

    public static $perPageViaRelationship = 10;

    public static $globallySearchable = true;

    public static $group = 'Change Management';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('User', 'modifier_id')->resolveUsing(function ($val) {
                return User::find($val)->name;
            })->sortable(),
            Text::make('Community', 'community_id')->resolveUsing(function ($val) {
                return '<a target="_blank" href="/admin/resources/c-m-communities/'.$val.'/">'.\App\Models\CMCommunity::find($val)->FRIENDLYNAME.'</a>';
            })->sortable()->asHtml(),
            Text::make('Field', 'modifications')->resolveUsing(function ($val) {
                switch ($val) {
                    case key($val) === 'SALESSTATUSID':
                        return 'Foreclosure Status';
                    default: return str_replace('_', ' ', Str::title(key($val)));
                }
            }),
            EllipsisTextarea::make('Original Value', 'modifications')->resolveUsing(function ($val) {
                switch ($val) {
                    case key($val) === 'rental_status' || key($val) === 'vacant_status' || key($val) === 'SALESSTATUSID':
                        return (new RentalVacantSalesStatus())->convertIdToSalesStatus(data_get($val, key($val).'.original'));
                    case key($val) === 'utility_data' || key($val) === 'cm_registrations_rental' || key($val) === 'cm_registrations_vacant' || key($val) === 'cm_registrations_foreclosure' || key($val) === 'strong_mayor' || key($val) === 'special_oversight' || key($val) === 'key_policy_agreement' || key($val) === 'rfp_status':
                        return (bool) data_get($val, key($val).'.original') ? 'True' : 'False';
                    case key($val) === 'relationship_status':
                        return (new CommunitySalesConfiguration())->convertIdToRelationshipStatus(data_get($val, key($val).'.original'));
                    case key($val) === 'onboarding_status':
                        return (new OnboardingStatus())->convertIdToStatus(data_get($val, key($val).'.original'));
                    case key($val) === 'opt_in_status':
                        return (new OptInStatus())->convertIdToStatus(data_get($val, key($val).'.original'));
                    case key($val) === 'violation_configuration':
                        return (new ViolationConfiguration())->convertIdToStatus(data_get($val, key($val).'.original'));
                    default: return data_get($val, key($val).'.original');
                }
            })->displayLength(18)->alwaysShow(),
            EllipsisTextarea::make('Modified Value', 'modifications')->resolveUsing(function ($val) {
                switch ($val) {
                    case key($val) === 'rental_status' || key($val) === 'vacant_status' || key($val) === 'SALESSTATUSID':
                        return (new RentalVacantSalesStatus())->convertIdToSalesStatus(data_get($val, key($val).'.modified'));
                    case key($val) === 'utility_data' || key($val) === 'cm_registrations_rental' || key($val) === 'cm_registrations_vacant' || key($val) === 'cm_registrations_foreclosure' || key($val) === 'strong_mayor' || key($val) === 'special_oversight' || key($val) === 'key_policy_agreement' || key($val) === 'rfp_status':
                        return (bool) data_get($val, key($val).'.modified') ? 'True' : 'False';
                    case key($val) === 'relationship_status':
                        return (new CommunitySalesConfiguration())->convertIdToRelationshipStatus(data_get($val, key($val).'.modified'));
                    case key($val) === 'onboarding_status':
                        return (new OnboardingStatus())->convertIdToStatus(data_get($val, key($val).'.modified'));
                    case key($val) === 'opt_in_status':
                        return (new OptInStatus())->convertIdToStatus(data_get($val, key($val).'.modified'));
                    case key($val) === 'violation_configuration':
                        return (new ViolationConfiguration())->convertIdToStatus(data_get($val, key($val).'.modified'));
                    default: return data_get($val, key($val).'.modified');
                }
            })->displayLength(18)->alwaysShow(),
            Date::make('Modified Date', 'created_at')->sortable(),
            Text::make('Status', 'active')->resolveUsing(function ($val) {
                if ($val == 1) {
                    return 'Pending';
                } else {
                    $query = Approval::where('modification_id', $this->id);
                    if ($query->count() > 0) {
                        return 'Approved by '.User::find($query->first()->approver_id)->name;
                    } elseif ($query->count() == 0) {
//                        return 'Denied';
                        return 'Denied by '.User::find(Disapproval::where('modification_id', $this->id)->first()->disapprover_id)->name;
                    }
                }
            }),
            Button::make('Approve', 'approve-modification')

                ->confirm('Are you sure you would like to approve the change?')
                ->style('success-outline')
                ->visible($this->active == true),
            Button::make('Deny', 'disapprove-modification')
                ->reload()
                ->confirm('Are you sure you would like to deny the change?')
                ->style('danger-outline')
                ->visible($this->active == true),

        ];
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public static function searchable()
    {
        return false;
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\ChangeRequestStatus(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
