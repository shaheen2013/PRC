<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;
use Davidpiesse\NovaToggle\Toggle;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\MultiselectField\Multiselect;
use Inspheric\NovaDefaultable\HasDefaultableFields;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;
use Manmohanjit\BelongsToDependency\BelongsToDependency;

class SalesCycle extends Resource
{
    use HasDefaultableFields;

    public static $globallySearchable = false;

    public static $group = '';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\SalesCycle::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static function searchable()
    {
        return false;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

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
            Text::make('Name'),
            Multiselect::make('Programs')
                ->options((new \App\Models\Program())->allOptions())
                ->placeholder('Choose the registration programs')
                ->max(3)
                ->optionsLimit(3)
                ->rules('required')
                ->hideFromIndex()
                ->hideWhenUpdating(),
            BelongsTo::make('Community', 'community', \App\Nova\CMCommunity::class)->searchable()->hideWhenUpdating(),

            BelongsToDependency::make('Lead', 'lead', \App\Nova\Contact::class)
                ->dependsOn('community', 'community_id')
                ->rules('required')
                ->hideWhenUpdating(),
            Toggle::make('Rental')->onlyOnIndex()->sortable(),
            Toggle::make('Vacant')->onlyOnIndex()->sortable(),
            Toggle::make('Foreclosure')->onlyOnIndex()->sortable(),

            Select::make('Sales Stage', 'sales_stage')
                ->options((new \App\Models\SalesCycle())->allSalesStatusOptions())
                ->displayUsingLabels()
                ->rules('required')
                ->hideWhenUpdating(),
            Date::make('Target Close Date')
                ->hideWhenUpdating()
                ->format('MMM DD YYYY')->sortable()
                ->rules('required'),
            Select::make('Deal Type', 'deal_type')
                ->options((new \App\Models\SalesCycle())->allDealTypeOptions())->displayUsingLabels()
                ->hideWhenUpdating()
                ->sortable()->rules('required'),
            HasMany::make('Sales Activities', 'salesActivities', SalesActivity::class),
            Toggle::make('Active')->hideWhenCreating(),

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
