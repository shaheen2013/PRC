<?php

namespace App\Nova;

use Dniccum\PhoneNumber\PhoneNumber;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use App\Models\InteractionType as Type;
use Outhebox\NovaHiddenField\HiddenField;
use OptimistDigital\MultiselectField\Multiselect;

class Interaction extends Resource
{

    public static $displayInNavigation = true;

    public static $globallySearchable = false;

    public static $group = '';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Interaction::class;

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
        'subject',
    ];

    public static function searchable()
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
            Select::make('Interaction Type', 'type_id')
                ->options(Type::all()->mapWithKeys(function ($status) {
                    return [$status['id'] => $status['label']];
                }))
                ->displayUsingLabels()
                ->rules('required'),

       //     dd(\App\CMCommunity::find($request->get('viaResourceId'))->contacts),

            Multiselect::make('People', 'contacts')
                ->options((\App\Models\Contact::where('community_id', $request->get('viaResourceId'))->get())->mapWithKeys(function ($contact) {
                    return [$contact['id'] => $contact['first_name'].' '.$contact['last_name']];
                }))
                ->placeholder('People')
                ->max(3)
                ->optionsLimit(3)
                ->rules('required')
                ->hideFromIndex(),

            BelongsTo::make('User')
                ->searchable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            BelongsTo::make('Community', 'community', \App\Nova\CMCommunity::class)
                ->searchable(),

            DateTime::make('Date')
                ->format('MMM DD YYYY')
                ->rules('required'),

            Text::make('Subject')
                ->rules('required'),

            PhoneNumber::make('Phone Number', 'phoneNumber')
                    ->country('US')->disableValidation(),
                Text::make('Email Address', 'email'),

            Text::make('Meeting Location', 'location'),

            HiddenField::make('User', 'user_id')
                ->current_user_id()
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenUpdating(),

            Trix::make('Body', 'body')->alwaysShow()
                ->rules('required'),

            BelongsToMany::make('People', 'contacts', Contact::class),

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
