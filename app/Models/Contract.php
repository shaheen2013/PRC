<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Approval\Traits\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Contract extends Model
{
    use LogsActivity;

    protected $connection = 'mysql_dev';

    protected $table = 'cm_contracts';

    protected $guarded = ['updated_at'];

    protected $dates = [
        'start_date',
        'expiration_date',
    ];

    protected $casts = [
        'vacant' => 'boolean',
        'foreclosure' => 'boolean',
        'rental' => 'boolean',
        'assignment' => 'boolean',
        'consent_required' => 'boolean',
        'notice_required' => 'boolean',
    ];

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logUnguarded = true;

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($contract) {
//            if ($contract->auto_renewal === true) {
//                $contract->expiration_date = Carbon::parse($contract->start_date)->addMonths(($contract->term_length) * ($contract->number_of_terms));
//            } else {
//                $contract->expiration_date = Carbon::parse($contract->start_date)->addMonths(($contract->term_length));
//            }
            if ($contract->programs !== null) {
                $contract->rental = Str::contains($contract->programs, '1');
                $contract->vacant = Str::contains($contract->programs, '2');
                $contract->foreclosure = Str::contains($contract->programs, '3');
            }
        });
    }

    protected function requiresApprovalWhen(array $modifications) : bool
    {
        // Handle some logic that determines if this change requires approval
        //
        // Return true if the model requires approval, return false if it
        // should update immediately without approval.
        return true;
    }

    //associates community id
    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_id = $this->community_id;
    }

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'community_id', 'COMMUNITYID');
    }

    public function program()
    {
        return $this->belongsTo(\App\Models\Program::class, 'program_id', 'id');
    }

    public function allRenewalOptions()
    {
        return [
            0 => 'Manual',
            1 => 'Auto',
            2 => 'Limitless Auto',
        ];
    }

    public function allTermOptions()
    {
        return [
            0 => '0',
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            99 => 'Limitless',
        ];
    }

    public function getLabel($id)
    {
        switch ($id) {
            case 0:
                return 'Manual';
            case 1:
                return 'Auto';
            case 2:
                return 'Limitless Auto';
            default:
                return 'Unknown';
        }
    }

    public function convertIdToStatus($id)
    {
        switch ($id) {
            case 0:
                return 'Manual';
            case 1:
                return 'Automatic';
            case 2:
                return 'Limitless Auto';
            default:
                return $id;
        }
    }
}
