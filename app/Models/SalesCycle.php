<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Approval\Traits\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class SalesCycle extends Model
{
    use LogsActivity;

    protected $connection = 'mysql_dev';

    protected $table = 'cm_sales_cycles';

    protected $guarded = ['updated_at'];

    protected $dates = [
        'target_close_date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'vacant' => 'boolean',
        'foreclosure' => 'boolean',
        'rental' => 'boolean',
        'active' => 'boolean',
        'community_id' => 'integer',
        'contact_id' => 'integer',
        'deal_type' => 'integer',
        'sales_stage' => 'integer',
    ];

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logUnguarded = true;

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($contract) {
            if ($contract->programs !== null) {
                $contract->rental = Str::contains($contract->programs, '1');
                $contract->vacant = Str::contains($contract->programs, '2');
                $contract->foreclosure = Str::contains($contract->programs, '3');
            }
        });
        static::updating(function ($contract) {
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

    public function lead()
    {
        return $this->belongsTo(\App\Models\Contact::class, 'contact_id', 'id');
    }

    public function salesActivities()
    {
        return $this->hasMany(\App\Models\SalesActivity::class, 'sales_cycle_id', 'id');
    }

    public function allDealTypeOptions()
    {
        return [
            0 => 'Unknown',
            1 => 'RFP',
            2 => 'Sole Source',
            3 => 'Piggyback',
        ];
    }

    public function convertIdToDealTypeLabel($id)
    {
        switch ($id) {
            case 0:
                return 'Unknown';
            case 1:
                return 'RFP';
            case 2:
                return 'Sole Source';
            case 3:
                return 'Piggyback';
            default:
                return 'Unknown';
        }
    }

    public function allSalesStatusOptions()
    {
        return [
            1 => '0 - No Activity',
            13 => '1 - Generate',
            11 => '2 - Guide',
            12 => '3 - Propose',
            6 => '4 - Onboard',
            5 => '5 - Enhance',
        ];
    }

    public function convertIdToSalesStatusLabel($id)
    {
        switch ($id) {
            case 1:
                return 'No Activity';
            case 5:
                return 'Enhance';
            case 6:
                return 'Onboard';
            case 7:
                return 'Generate';
            case 10:
                return 'No Interest';
            case 11:
                return 'Guide';
            case 12:
                return 'Propose';
            case 13:
                return 'Generate';
            case 14:
                return 'Upgrade';
            default:
                return 'Unknown';
        }
    }
}
