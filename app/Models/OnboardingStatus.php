<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingStatus extends Model
{
    protected $connection = 'mysql_dev';

    protected $table = 'cm_onboarding_statuses';

    protected $guarded = [];

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'onboarding_status', 'id');
    }

    public function allOptions()
    {
        return [
            1 => 'Started',
            2 => 'Selection Confirmed',
            3 => 'Contract Executed',
            4 => 'Live for Registrations',
            5 => 'OTRs Notified',
            6 => 'Complete',
        ];
    }

    public function convertIdToStatus($id)
    {
        switch ($id) {
            case 1:
                return 'Started';
            case 2:
                return 'Selection Confirmed';
            case 3:
                return 'Contract Executed';
            case 4:
                return 'Live for Registration';
            case 5:
                return 'OTRs Notified';
            case 6:
                return 'Complete';
            default:
                return 'No Activity';
        }
    }
}
