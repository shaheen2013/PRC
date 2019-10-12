<?php

namespace App\Nova;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use NovaAjaxSelect\AjaxSelect;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\MultiselectField\Multiselect;
use Inspheric\NovaDefaultable\HasDefaultableFields;

class SalesActivity extends Resource
{
    use HasDefaultableFields;

    public static $with = [
        'salesCycle',
    ];

    public static $displayInNavigation = false;

    public static $globallySearchable = false;

    public static $group = '';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\SalesActivity::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'subject';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        '',
    ];

    public static function searchable()
    {
        return false;
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        if ($request->viaResource) {
            return "/resources/{$request->viaResource}/{$request->viaResourceId}";
        }

        return parent::redirectAfterUpdate($request, $resource);
    }

    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        if ($request->viaResource) {
            return "/resources/{$request->viaResource}/{$request->viaResourceId}";
        }

        return parent::redirectAfterCreate($request, $resource);
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
            Date::make('Activity Date')->size('w-4/5 remove-bottom-border')
                ->format('MMM DD YYYY')->sortable()
                ->rules('required'),

            BelongsTo::make('Community', 'community', \App\Nova\CMCommunity::class)->size('w-1/5')
                ->searchable()
                ->withMeta(['extraAttributes' => [
                    'readonly' => true,
                    'disabled' => true,
                ]])
                ->default(function (NovaRequest $request) {
                    return $request->findParentResourceOrFail()->community_id;
                }),

            Text::make('Subject')->size('w-4/5')
                ->rules('required'),

            BelongsTo::make('Sales Cycle', 'salesCycle', \App\Nova\SalesCycle::class)->searchable()->size('w-1/5'),

            Textarea::make('Body')->alwaysShow()->size('w-4/5')
                ->rules('required'),

            Multiselect::make('Programs')
                ->options((new \App\Models\Program())->allOptions())
                ->placeholder('Choose the registration programs')
                ->max(3)
                ->optionsLimit(3)
                ->rules('required')
                ->size('w-1/5')
                ->hideFromIndex()
                ->default(function (NovaRequest $request) {
                    return $request->findParentResourceOrFail()->programs;
                }),

            Select::make('Deal Type', 'deal_type')->size('w-1/5')
                ->options((new \App\Models\SalesCycle())->allDealTypeOptions())->displayUsingLabels()
                ->sortable()->rules('required')
                ->default(function (NovaRequest $request) {
                    return $request->findParentResourceOrFail()->deal_type;
                }),

            AjaxSelect::make('Lead', 'contact_id')->size('w-1/5')
                ->get('/api/community/{community}/contacts')
                ->parent('community')
                ->default(function (NovaRequest $request) {
                    return $request->findParentResourceOrFail()->contact_id;
                }),

            Date::make('Target Close Date')->size('w-1/5')
                ->format('MMM DD YYYY')->sortable()
                ->rules('required')
                ->default(function (NovaRequest $request) {
                    return Carbon::parse($request->findParentResourceOrFail()->target_close_date)->toDateString();
                }),

            Select::make('Sales Stage', 'sales_stage')->size('w-1/5')
                ->options((new \App\Models\SalesCycle())->allSalesStatusOptions())
                ->displayUsingLabels()
                ->rules('required')->default(function (NovaRequest $request) {
                    return $request->findParentResourceOrFail()->sales_stage;
                }),
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
