<?php

namespace App\Nova;

use App\Models\OptInStatus;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasOne;
use App\Models\OnboardingStatus;
use App\Models\RelationshipStatus;
use Laravel\Nova\Fields\BelongsTo;
use App\Models\ViolationConfiguration;
use App\Models\RentalVacantSalesStatus;
use Laravel\Nova\Http\Requests\NovaRequest;

class ActivityLog extends Resource
{
    public static $globallySearchable = false;

    public static $group = '';

    public static $displayInNavigation = false;

    public static $perPageViaRelationship = 20;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ActivityLog::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function searchable()
    {
        return false;
    }

    public static $indexDefaultOrder = [
        'updated_at' => 'desc',
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        \Log::debug($request);

        $query->getQuery()->orders = null;
        $query->orderBy('updated_at', 'desc');
    }

    public static function relatableQuery(NovaRequest $request, $query)
    {
        \Log::debug('testing', $request);

        return $query;
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

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Date::make('Date', 'created_at')->sortable()->exceptOnForms(),

            Text::make('Activity Type', 'description')->resolveUsing(function ($activityType) {
                return ucfirst($activityType);
            })->sortable(),

            BelongsTo::make('User', 'user', \App\Nova\User::class)->sortable(),

            Text::make('Subject', 'subject_type')->resolveUsing(function ($subject) {
                return (new \App\Models\ActivityLog())->convertSubjectToHumanReadable($subject);
            })->sortable(),

            Text::make('Fields Changed', 'properties')->resolveUsing(function ($properties) {
                $propertiesObj = json_decode($properties)->attributes;
                unset($propertiesObj->updated_at);
                unset($propertiesObj->programs);
                if ($this->description === 'updated') {
                    $oldPropertiesObj = json_decode($properties)->old;
                    unset($oldPropertiesObj->updated_at);
                    foreach ($propertiesObj as $key => $value) {
                        if ($key === 'rental_status' || $key === 'vacant_status' || $key === 'SALESSTATUSID') {
                            $value = (new RentalVacantSalesStatus())->convertIdToSalesStatus($value);
                            $oldPropertiesObj->$key = (new RentalVacantSalesStatus())->convertIdToSalesStatus($oldPropertiesObj->$key);
                        }
                        if ($value === null || $value === '') {
                            $value = 'Null';
                            $oldPropertiesObj->$key = 'Null';
                        }
                        if ($value === true) {
                            $value = 'True';
                            $oldPropertiesObj->$key = 'False';
                        }
                        if ($value === false) {
                            $value = 'False';
                            $oldPropertiesObj->$key = 'True';
                        }
                        if ($key === 'number_of_terms') {
                            if ($value == 0) {
                                $value = 'Limitless';
                            } elseif ($oldPropertiesObj->$key == 0) {
                                $oldPropertiesObj->$key = 'Limitless';
                            }
                        }
                        if ($key === 'auto_renewal') {
                            $value = (new \App\Models\Contract())->convertIdToStatus($value);
                            $oldPropertiesObj->$key = (new \App\Models\Contract())->convertIdToStatus($oldPropertiesObj->$key);
                        }
                        if ($key === 'onboarding_status') {
                            $value = (new OnboardingStatus())->convertIdToStatus($value);
                            $oldPropertiesObj->$key = (new OnboardingStatus())->convertIdToStatus($oldPropertiesObj->$key);
                        }
                        if ($key === 'violation_configuration') {
                            $value = (new ViolationConfiguration())->convertIdToStatus($value);
                            $oldPropertiesObj->$key = (new ViolationConfiguration())->convertIdToStatus($oldPropertiesObj->$key);
                        }
                        if ($key === 'relationship_status') {
                            $value = (new RelationshipStatus())->convertIdToStatus($value);
                            $oldPropertiesObj->$key = (new RelationshipStatus())->convertIdToStatus($oldPropertiesObj->$key);
                        }
                        if ($key === 'opt_in_status') {
                            $value = (new OptInStatus())->convertIdToStatus($value);
                            $oldPropertiesObj->$key = (new OptInStatus())->convertIdToStatus($oldPropertiesObj->$key);
                        }
                        if ($oldPropertiesObj->$key === null || $oldPropertiesObj->$key === '') {
                            $oldPropertiesObj->$key = 'Null';
                        }
                        $propertiesObj->$key =
                            "<div>
                                <span class='text-lg font-semibold'>"
                                    .str_replace('_', ' ', Str::title((new \App\Models\ActivityLog())->translateFieldName($key))).'
                                </span>&nbsp;&ndash;&nbsp;'.
                                "<span class='font-semibold'>
                                    Old: 
                                </span>".$oldPropertiesObj->$key.'&nbsp;&nbsp;&nbsp;
                                <span class="font-semibold">
                                    New: 
                                </span>'.$value.
                            '</div>';
                    }

                    return implode('', array_values((array) $propertiesObj));
                } else {
                    unset($propertiesObj->id);
                    unset($propertiesObj->created_at);
                    unset($propertiesObj->survival);
                    unset($propertiesObj->deleted_at);
                    unset($propertiesObj->private);

                    foreach ($propertiesObj as $key => $value) {
//                        if ($value == null || $value == "") {
//                            unset($propertiesObj->$key);
//                        }
//                        if ($value === null || $value === "") {
//                            $value = "Null";
//                        }
                        if ($value === true) {
                            $value = 'True';
                        }
                        if ($value === false) {
                            $value = 'False';
                        }
                        if ($key === 'auto_renewal') {
                            $value = (new \App\Models\Contract())->convertIdToStatus($value);
                        }
                        if ($key === 'number_of_terms') {
                            if ($value == 0) {
                                $value = 'Limitless';
                            }
                        }

                        $propertiesObj->$key = "<div>
                                <span class='text-lg font-semibold'>"
                            .str_replace('_', ' ', Str::title((new \App\Models\ActivityLog())->translateFieldName($key))).'
                                </span>&nbsp;&ndash;&nbsp;'.$value.'</div>';
                    }

                    return implode('', array_values((array) $propertiesObj));
                }
            })->asHtml(),
        ];
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
        return [];
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
