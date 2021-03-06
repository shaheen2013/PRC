<?php

namespace App\Nova\Filters;

use App\Models\SalesStatus;
use Illuminate\Http\Request;
use App\Models\CommunityStatus;
use Laravel\Nova\Filters\Filter;

class CommunityVacantStatus extends Filter
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
        return $query->whereHas('rentalVacantSalesStatus', function ($q) use ($value) {
            if ($value == 7 || $value == 13) {
                $q->where('vacant_status', '=', 7)->orWhere('vacant_status', '=', 13);
            } else {
                $q->where('vacant_status', '=', $value);
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
            '(0) No Activity' => 1,
            '(1) Generate' => 7,
            '(2) Guide' => 11,
            '(3) Propose' => 12,
            '(4) Onboard' => 6,
            '(5) Enhance & Renew' => 5,
        ];
    }
}
