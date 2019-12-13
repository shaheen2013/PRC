<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class CommunityRentalSalesStatus extends BooleanFilter
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
        if($value['orActive']){
            return $query;
        }
        if ($value['value'] == false) {
            return $query;
        } else {
            return $query->whereHas('rentalVacantSalesStatus', function ($q) use ($value) {
                if ($value['value'] == true) {
                    $q->where('rental_partner_status', '=', 1);
                }
            });
        }
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
            0 => 'value',
            1 => 'orActive',
        ];
    }
}
