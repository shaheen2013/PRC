<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class CommunitySalesCycleBool extends BooleanFilter
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
        if ($value[11] == false && $value[12] == false && $value[13] == false && $value[6] == false) {
            return $query;
        } else {
            return $query->whereHas('salesCycles', function ($q) use ($value) {
                if ($value[11] == true) {
                    $q->where('sales_stage', '=', 11);
                }
                if ($value[12] == true) {
                    $q->where('sales_stage', '=', 12);
                }
                if ($value[13] == true) {
                    $q->where('sales_stage', '=', 13);
                }
                if ($value[6] == true) {
                    $q->where('quartile', '=', 6);
                }
                $query;
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
            'Generate' => 13,
            'Guide' => 11,
            'Propose' => 12,
            'Onboard' => 6
        ];
    }
}
