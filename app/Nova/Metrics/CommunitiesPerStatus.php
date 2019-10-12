<?php

namespace App\Nova\Metrics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class CommunitiesPerStatus extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, Community::class, 'community_status_id')
            ->label(function ($value) {
                switch ($value) {
                    case null:
                        return 'None';
                    case 1:
                        return 'Not Reviewed';
                    case 3:
                        return 'Approved';
                    case 4:
                        return 'Update Saved';
                    case 5:
                        return 'Pending Approval';
                    case 6:
                        return 'No Ordinance';
                    case 7:
                        return 'Update Requested';
                    default:
                        return 'Not Reviewed';
                }
            });
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addMinutes(60);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'communities-per-status';
    }
}
