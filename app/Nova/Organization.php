<?php

namespace App\Nova;

use App\Models\State;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsToMany;
use Bissolli\NovaPhoneField\PhoneNumber;
use Laravel\Nova\Http\Requests\NovaRequest;

class Organization extends Resource
{
    public static $group = '';

    public static $displayInNavigation = false;

    public static $globallySearchable = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Organization::class;

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
    ];

    /**
     * Get the displayble label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'RMs';
    }

    /**
     * Get the displayble singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'RM';
    }

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->name;
    }

    public function subtitle()
    {
        return "{$this->city}, {$this->state}";
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
            Place::make('Address')
                ->hideFromIndex()
                ->postalCode('zipcode'),
            PhoneNumber::make('Phone Number', 'phone')
                ->onlyCountries('US')
                ->hideFromIndex(),
            Text::make('City')->hideFromIndex(),
            Select::make('State')->hideFromIndex()
                ->options(State::all()->mapWithKeys(function ($state) {
                    return [$state['code'] => $state['name']];
                })),
            Text::make('Website')
                ->hideFromIndex(),
            Trix::make('Note')
                ->hideFromIndex(),
            BelongsToMany::make('Communities')
                ->fields(function () {
                    return [
                        Number::make('Rm Amount', 'rm_amount')
                            ->step(.01)
                            ->displayUsing(function ($field) {
                                return isset($this->pivot) ? $this->pivot->rm_amount : '-';
                            }),
                    ];
                })->searchable(),
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
