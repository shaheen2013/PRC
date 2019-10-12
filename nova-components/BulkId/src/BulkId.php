<?php

namespace Prochamps\BulkId;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class BulkId extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'bulk-id';

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
        return $query->whereIn('COMMUNITYID', array_filter(preg_split('/\r\n|\r|\n/', $value)));
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
