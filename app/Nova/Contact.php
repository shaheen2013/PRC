<?php

namespace App\Nova;

use Davidpiesse\NovaToggle\Toggle;
use Dniccum\PhoneNumber\PhoneNumber;
use Eminiarts\Tabs\Tabs;
use Inspheric\Fields\Email;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Eminiarts\Tabs\TabsOnEdit;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Saumini\EllipsisTextarea\EllipsisTextarea;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class Contact extends Resource
{
    use TabsOnEdit;

    public static $group = '';

    public static $perPageViaRelationship = 10;

    public static $displayInNavigation = true;

    public static $globallySearchable = true;

    public static function searchable()
    {
        return false;
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Contact::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'full_name';

    public function subtitle()
    {
        return "{$this->email}";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'first_name',
        'last_name',
        'email',
    ];

    public static $indexDefaultOrder = [
        'first_name' => 'asc',
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];

            return $query->orderBy(key(static::$indexDefaultOrder), reset(static::$indexDefaultOrder));
        }

        return $query;
    }

    public static function uriKey()
    {
        return 'people';
    }

    public function title()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public static function label()
    {
        return 'People';
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
            Text::make('First Name', 'first_name')
                ->sortable(),
            Text::make('Last Name', 'last_name')
                ->sortable(),
            EllipsisTextarea::make('Title')->sortable()->displayLength(25)->alwaysShow(),
            BelongsTo::make('Community', 'community', \App\Nova\CMCommunity::class)->searchable()->sortable()->nullable(),
            Toggle::make('Remittance Contact', 'is_remittance_contact')->onlyOnIndex()->sortable(),
            (new Tabs('Person Configuration', [
                'Basic Information' => [
                    Email::make('Email')
                        ->clickableOnIndex()
                        ->clickable()
                        ->sortable(),
                    Text::make('Suffix')
                        ->hideFromIndex(),
                    Text::make('Company Name')
                        ->hideFromIndex(),
                    Trix::make('Description', 'description')
                        ->alwaysShow()
                        ->hideFromIndex(),
                ],
                'Phone Numbers'    => [
                    PhoneNumber::make('Primary Phone Number', 'primary_phone')
                        ->hideFromIndex()
                        ->disableValidation(),
                    Number::make('Primary Phone Number Ext', 'primary_phone_ext')
                        ->hideFromIndex(),
                    PhoneNumber::make('Secondary Phone Number', 'secondary_phone')
                        ->hideFromIndex()
                        ->disableValidation(),
                    Number::make('Secondary Phone Number Ext', 'secondary_phone_ext')
                        ->hideFromIndex(),
                    PhoneNumber::make('Fax', 'fax')
                        ->hideFromIndex()
                        ->disableValidation(),
                ],
                'Address' => [
                    Place::make('Street')
                        ->hideFromIndex()
                        ->postalCode('zipcode'),
                    Text::make('City')
                        ->hideFromIndex(),
                    Text::make('State')
                        ->hideFromIndex(),
                    Text::make('Zipcode', 'zipcode')
                        ->hideFromIndex(),
                ],
                'Social Media Information' => [
                    Text::make('Website')
                        ->hideFromIndex(),
                    Text::make('Facebook')
                        ->hideFromIndex(),
                    Text::make('Linkedin')
                        ->hideFromIndex(),
                ],
                BelongsToMany::make('Roles', 'roles', PeopleRoles::class),
                HasMany::make('Interactions', 'interactions', Interaction::class),
            ]))->defaultSearch(true),
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
        return [
//            new Metrics\NewContacts(),
         //   new Metrics\NewInteractions()
//            new Metrics\InteractionsPerDay()
        ];
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
        ini_set('max_execution_time', 180);

        return [
            new DownloadExcel,
            //new Actions\AttachContactToCommunity()
        ];
    }
}
