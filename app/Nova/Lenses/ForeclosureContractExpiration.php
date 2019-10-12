<?php

namespace App\Nova\Lenses;

use Carbon\Carbon;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Http\Requests\LensRequest;

class ForeclosureContractExpiration extends Lens
{
    public static $resourceTable = 'osusr_mlv_community';

    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public $name = 'Foreclosure Partnered Contracts';

    public static function query(LensRequest $request, $query)
    {
        $resourceTable = 'osusr_mlv_community';
        $orderBy = $request->get('orderBy');
        $query->getQuery()->orders = null;

        if ($orderBy == 'PARTNERDATE') {
            $query->getQuery()->orders = null;

            return $request->withFilters(
                $query->select(self::columns())
                    ->join('osusr_tvl_crm as u', "{$resourceTable}.COMMUNITYID", '=', 'u.COMMUNITYID')
                    ->where('u.CONTRACTEXPIRATIONDATE', '!=', '1900-01-01 00:00:00')
                    ->orderBy('u.PARTNERDATE', $request->get('orderByDirection'))
            );
        } elseif ($orderBy == 'CONTRACTEFFECTIVEDATE') {
            $query->getQuery()->orders = null;

            return $request->withFilters(
                $query->select(self::columns())
                    ->join('osusr_tvl_crm as u', "{$resourceTable}.COMMUNITYID", '=', 'u.COMMUNITYID')
                    ->where('u.CONTRACTEXPIRATIONDATE', '!=', '1900-01-01 00:00:00')
                    ->orderBy('u.CONTRACTEFFECTIVEDATE', $request->get('orderByDirection'))
            );
        } elseif ($orderBy == 'CONTRACTEXPIRATIONDATE') {
            $query->getQuery()->orders = null;

            return $request->withFilters(
                $query->select(self::columns())
                    ->join('osusr_tvl_crm as u', "{$resourceTable}.COMMUNITYID", '=', 'u.COMMUNITYID')
                    ->where('u.CONTRACTEXPIRATIONDATE', '!=', '1900-01-01 00:00:00')
                    ->orderBy('u.CONTRACTEXPIRATIONDATE', $request->get('orderByDirection'))
            );
        } else {
            return $request->withOrdering($request->withFilters(
                $query->select(self::columns())
                    ->join('osusr_tvl_crm as u', "{$resourceTable}.COMMUNITYID", '=', 'u.COMMUNITYID')
                    ->where('u.CONTRACTEXPIRATIONDATE', '!=', '1900-01-01 00:00:00')
                    ->orderBy('u.CONTRACTEXPIRATIONDATE', $request->get('orderByDirection'))
            ));
        }
    }

    /**
     * Get the columns that should be selected.
     *
     * @return array
     */
    protected static function columns()
    {
        $resourceTable = self::$resourceTable;

        return [
            'osusr_mlv_community.COMMUNITYID',
            'FRIENDLYNAME',
            'u.CONTRACTEXPIRATIONDATE',
            'u.PARTNERDATE',
            'U.CONTRACTEFFECTIVEDATE',
        ];
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('Id', 'COMMUNITYID')->sortable(),
            Text::make('Community', 'FRIENDLYNAME')->sortable()->hideFromIndex(),
            Text::make('Expiration Date', 'CONTRACTEXPIRATIONDATE')->resolveUsing(function ($rawDate) {
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
                    return "<span style='color:{$color};'>Expired {$date->diffForHumans(null, false, false, 3)}</span>";
                } else {
                    return "<span style='color:{$color};'>Expires {$date->diffForHumans(null, false, false, 3)}</span>";
                }
            })->asHtml()->sortable(),
            Date::make('Partner Date', 'PARTNERDATE')->format('MMM DD YYYY')->sortable(),
            Date::make('Contract Effective Date', 'CONTRACTEFFECTIVEDATE')->format('MMM DD YYYY')->sortable(),
        ];
    }

    /**
     * Get the cards available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new \App\Nova\Metrics\ForeclosureContractExpiration(),
        ];
    }

    /**
     * Get the actions available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'foreclosure-contract-expiration';
    }
}
