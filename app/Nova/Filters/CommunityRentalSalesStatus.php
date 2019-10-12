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
        if ($value[1] == false && $value[7] == false && $value[11] == false && $value[12] == false && $value[6] == false && $value[5] == false && $value[14] == false) {
            return $query;
        } else {
            return $query->whereHas('rentalVacantSalesStatus', function ($q) use ($value) {
                if ($value[1] == true) {
                    $q->where('rental_status', '=', 1);
                }
                if ($value[7] == true) {
                    if ($value[1] == true) {
                        $q->orWhere('rental_status', '=', 7)->orWhere('rental_status', '=', 13);
                    } else {
                        $q->where('rental_status', '=', 7)->orWhere('rental_status', '=', 13);
                    }
                }
                if ($value[11] == true) {
                    if ($value[1] == true | $value[7] == true) {
                        $q->orWhere('rental_status', '=', 11);
                    } else {
                        $q->where('rental_status', '=', 11);
                    }
                }
                if ($value[12] == true) {
                    if ($value[1] == true | $value[7] == true | $value[11] == true) {
                        $q->orWhere('rental_status', '=', 12);
                    } else {
                        $q->where('rental_status', '=', 12);
                    }
                }
                if ($value[6] == true) {
                    if ($value[1] == true | $value[7] == true | $value[11] == true | $value[12 == true]) {
                        $q->orWhere('rental_status', '=', 6);
                    } else {
                        $q->where('rental_status', '=', 6);
                    }
                }
                if ($value[5] == true) {
                    if ($value[1] == true | $value[7] == true | $value[11] == true | $value[12] == true | $value[6] == true) {
                        $q->orWhere('rental_status', '=', 5);
                    } else {
                        $q->where('rental_status', '=', 5);
                    }
                }
                if ($value[14] == true) {
                    if ($value[1] == true | $value[7] == true | $value[11] == true | $value[12] == true | $value[6] == true | $value[5] == true) {
                        $q->orWhere('rental_status', '=', 14);
                    } else {
                        $q->where('rental_status', '=', 14);
                    }
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
            '0 - No Activity' => 1,
            '1 - Generate' => 7,
            '2 - Guide' => 11,
            '3 - Propose' => 12,
            '4 - Onboard' => 6,
            '5 - Enhance & Renew' => 5,
            '6 - Upgrade' => 14,
        ];
    }
}
