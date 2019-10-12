<?php

namespace App\Nova\Metrics;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CRMCommunitySale;
use Laravel\Nova\Metrics\Partition;

class ForeclosureContractExpiration extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $expired = CRMCommunitySale::where('SALESSTATUSID', '=', 5)
            ->where('CONTRACTEXPIRATIONDATE', '<', Carbon::now())
            ->count();
        $under = CRMCommunitySale::where('SALESSTATUSID', '=', 5)
            ->where('CONTRACTEXPIRATIONDATE', '>', Carbon::now())
            ->where('CONTRACTEXPIRATIONDATE', '<', Carbon::now()->addDay(30))
            ->count();
        $middle = CRMCommunitySale::where('SALESSTATUSID', '=', 5)
            ->where('CONTRACTEXPIRATIONDATE', '>=', Carbon::now()->addDays(30))
            ->where('CONTRACTEXPIRATIONDATE', '<=', Carbon::now()->addDays(90))
            ->count();
        $over = CRMCommunitySale::where('SALESSTATUSID', '=', 5)
            ->where('CONTRACTEXPIRATIONDATE', '>', Carbon::now()->addDays(90))
            ->count();

        return $this->result([
            'Expired' => $expired,
            'Under 30 Days' => $under,
            '30-90 Days' => $middle,
            'Over 90 Days' => $over,
        ]);
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addDay();
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
