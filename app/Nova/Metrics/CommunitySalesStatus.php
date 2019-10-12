<?php

namespace App\Nova\Metrics;

use Illuminate\Http\Request;
use App\Models\CRMCommunitySale;
use Laravel\Nova\Metrics\Partition;

class CommunitySalesStatus extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, CRMCommunitySale::class, 'SALESSTATUSID')
            ->label(function ($value) {
                switch ($value) {
                    case null:
                        return 'None';
                    case 1:
                        return 'No Activity';
                    case 5:
                        return 'Partner';
                    case 6:
                        return 'Engaged';
                    case 7:
                        return 'Target 1';
                    case 10:
                        return 'No Interest';
                    case 11:
                        return 'Target 2';
                    case 12:
                        return 'Target 3';
                    case 13:
                        return 'Prospect';
                    default:
                        return 'None';
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
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'community-sales-status';
    }
}
