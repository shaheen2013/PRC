<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ChangeRequestStatus extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  Request  $request
     * @param  Builder  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        switch ($value) {
            case 0:
                return $query->where('active', 0);
            case 1:
                return $query->where('active', 1);
            case 2:
                return $query->where('active', 0)->join('approvals', 'modifications.id', '=', 'approvals.modification_id');
            case 3:
                return $query->where('active', 0)->join('disapprovals', 'modifications.id', '=', 'disapprovals.modification_id');
            default:
                return $query;
        }
    }

    /**
     * Get the filter's available options.
     *
     * @param  Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Completed' => 0,
            'Pending' => 1,
//            "Approved" => 2,
//            "Declined" => 3
        ];
    }
}
