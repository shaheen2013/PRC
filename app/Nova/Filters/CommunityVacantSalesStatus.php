<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class CommunityVacantSalesStatus extends BooleanFilter
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
        }

        return $query->whereHas('rentalVacantSalesStatus', function ($q) use ($value) {
            if ($value[1] == true) {
                $q->where('vacant_status', '=', 1);
            }
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
