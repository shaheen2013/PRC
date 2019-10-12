<?php

namespace App\Nova;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Davidpiesse\NovaToggle\Toggle;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Actions\ExportContracts;
use App\Nova\Filters\ContractExpired;
use App\Nova\Actions\ExportCommunities;
use App\Nova\Filters\ContractExpiration;
use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\MultiselectField\Multiselect;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class Contract extends Resource
{
    public static $globallySearchable = false;

    public static $group = '';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Contract::class;

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
        '',
    ];

    public static function searchable()
    {
        return false;
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        $query->getQuery()->orders = null;
        $query->orderBy('expiration_date', 'asc');
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
            Multiselect::make('Programs')
                ->options((new \App\Models\Program())->allOptions())
                ->placeholder('Choose the registration programs')
                ->max(3)
                ->optionsLimit(3)
                ->rules('required')
                ->hideFromIndex(),
            BelongsTo::make('Community', 'community', \App\Nova\CMCommunity::class)->searchable(),
            Toggle::make('Rental')->onlyOnIndex()->sortable(),
            Toggle::make('Vacant')->onlyOnIndex()->sortable(),
            Toggle::make('Foreclosure')->onlyOnIndex()->sortable(),
            Date::make('Start Date')
                ->format('MMM DD YYYY')->sortable(),
            Date::make('Expiration Date')
                ->format('MMM DD YYYY')->sortable(),
            Text::make('Expires', 'expiration_date')->resolveUsing(function ($rawDate) {
                $date = new Carbon($rawDate);
                $diff = $date->diffInDays(Carbon::now(), false);
                if ($diff < -90) {
                    $color = 'green';
                } elseif ($diff < -29 && $diff > -91) {
                    $color = 'gold';
                } else {
                    $color = 'red';
                }
                if ($diff > 0) {
                    return "<span style='color:{$color};'>{$date->diffForHumans(null, false, false, 2)}</span>";
                } else {
                    return "<span style='color:{$color};'>{$date->diffForHumans(null, false, false, 2)}</span>";
                }
            })->asHtml()->sortable()->exceptOnForms(),
            Select::make('Renewal Policy', 'auto_renewal')
                ->options((new \App\Models\Contract())->allRenewalOptions())
                ->displayUsingLabels()
                ->sortable()->hideFromIndex(),
            Select::make('# of Terms Remaining', 'number_of_terms')
                ->options((new \App\Models\Contract())->allTermOptions())->displayUsingLabels()
                ->sortable()->rules('required'),
            Number::make('Term Length in Months', 'term_length')->sortable()->rules('required'),
            Toggle::make('Assignment Necessary', 'assignment')->sortable()->hideFromIndex(),
            Toggle::make('Consent Required')->sortable()->hideFromIndex(),
            Toggle::make('Notice of Change Required', 'notice_required')->sortable()->hideFromIndex(),
            Trix::make('Notes', 'description')->sortable()->hideFromIndex()->alwaysShow(),
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
        return [
            new ContractExpired(),
            new ContractExpiration(),
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
        return [
            (new ExportContracts())
                ->withChunkCount(200)
                ->withFilename('Contract_List-'.Carbon::now()->format('YmdHs').'.xlsx')
                ->withHeadings('Community', 'Rental', 'Vacant', 'Foreclosure', 'Start Date', 'Expiration Date',
                    'Expires', '# of Terms', 'Term Length', 'Renewal Policy', 'Assignment Necessary', 'Consent Required', 'Notice Required',
                    'Description')
                ->onlyOnIndex(),
        ];
    }
}
