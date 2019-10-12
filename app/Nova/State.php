<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Davidpiesse\NovaToggle\Toggle;
use App\Models\StateGovernanceOptions;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\StateForeclosureProcessConfig;

class State extends Resource
{
    public static $globallySearchable = false;

    public static $group = '';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\State::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'code',
    ];

    public static function label()
    {
        return 'States';
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    /**
     * Return the location to redirect the user after update.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \App\Nova\Resource $resource
     * @return string
     */
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        if ($request->get('viaResourceId')) {
            return '/resources/c-m-communities/'.$request->get('viaResourceId');
        } else {
            return '/resources/'.static::uriKey().'/';
        }
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        $query->getQuery()->orders = null;
        $query->orderBy('id', 'asc');
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
            Text::make('Abbreviation', 'code')->exceptOnForms(),
            Text::make('name')->readonly()->sortable(),
            Select::make('State Foreclosure Process', 'state_foreclosure_process')
                ->options((new StateForeclosureProcessConfig())->allOptions())
                ->displayUsingLabels()
                ->sortable(),
            Select::make('State Governance', 'state_governance')
                ->options((new StateGovernanceOptions())->allOptions())
                ->displayUsingLabels()
                ->sortable(),
            Toggle::make('Excluded', 'excluded')->sortable(),
            Text::make('Excluded Notes', 'excluded_notes')->sortable()->hideFromIndex(),
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
