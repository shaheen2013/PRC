<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Remittance extends Resource
{
    public static $displayInNavigation = false;

    public static $globallySearchable = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CMRemittanceConfig::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'ID';

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

    public static function indexQuery(NovaRequest $request, $query)
    {
        $query->getQuery()->orders = null;
        $query->orderBy('CATEGORYID', 'asc');
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
            Text::make('Category', 'category.LABEL')->sortable(),
            Text::make('Registration Fee', 'REFERENCEFEE')->displayUsing(function ($fee) {
                if ($fee == 0) {
                    return 'Default';
                } else {
                    return '$'.(int) $fee;
                }
            })->sortable(),
            Text::make('PRC Fee', 'REMITFEE')->displayUsing(function ($fee) {
                return '$'.$fee;
            })->sortable(),
            Text::make('PRC Late Fee', 'REMITLATEFEE')->displayUsing(function ($fee) {
                return $fee.'%';
            })->sortable(),
            Text::make('PRC Inspection Fee', 'REMITINSPECTIONFEE')->displayUsing(function ($fee) {
                return $fee.'%';
            })->sortable(),
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
