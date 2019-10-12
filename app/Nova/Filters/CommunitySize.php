<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class CommunitySize extends BooleanFilter
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
        if ($value[0] == false && $value[1] == false && $value[2] == false && $value[3] == false && $value[4] == false) {
            return $query;
        } else {
            return $query->whereHas('housingData', function ($q) use ($value) {
                if ($value[0] == true) {
                    $q->where('quartile', '=', 0);
                }
                if ($value[1] == true) {
                    if ($value[0] == true) {
                        $q->orWhere('quartile', '=', 1);
                    } else {
                        $q->where('quartile', '=', 1);
                    }
                }
                if ($value[2] == true) {
                    if ($value[0] == true | $value[1] == true) {
                        $q->orWhere('quartile', '=', 2);
                    } else {
                        $q->where('quartile', '=', 2);
                    }
                }
                if ($value[3] == true) {
                    if ($value[0] == true | $value[1] == true | $value[2] == true) {
                        $q->orWhere('quartile', '=', 3);
                    } else {
                        $q->where('quartile', '=', 3);
                    }
                }
                if ($value[4] == true) {
                    if ($value[0] == true | $value[1] == true | $value[2] == true | $value[3] == true) {
                        $q->orWhere('quartile', '=', 4);
                    } else {
                        $q->where('quartile', '=', 4);
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
            'X-Large' => 4,
            'Large' => 3,
            'Medium' => 2,
            'Small' => 1,
            'X-Small' => 0,
        ];
    }
}
