<?php

namespace Prochamps\StateCounty;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class StateCounty extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'state-county';

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
        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [];
    }
}
