<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class CommunityOrFilter extends BooleanFilter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if(!$value){
            return $query;
        }
        if($value['rental'] === false && $value['vacant'] === false && $value['foreclosure'] === false){
            return $query;
        }
        return $query->whereHas('rentalVacantSalesStatus', function ($qq) use ($value) {
            $qq->where(function($q) use($value){
                if ($value['rental'] === true) {
                    $q->orwhere('rental_partner_status', '=', 1);
                }
                if($value['vacant'] === true){
                    $q->orwhere('vacant_partner_status', '=', 1);
                }
                if($value['foreclosure'] === true){
                    $q->orwhere('foreclosure_partner_status', '=', 1);
                }
            });
        });
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            0 => 'rental',
            1 => 'vacant',
            2 => 'foreclosure'
        ];
    }
}
