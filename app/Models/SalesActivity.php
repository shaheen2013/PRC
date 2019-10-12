<?php

namespace App\Models;

use Illuminate\Support\Str;
use Approval\Traits\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class SalesActivity extends Model
{
    use LogsActivity;

    protected $connection = 'mysql_dev';

    protected $table = 'cm_sales_activities';

    protected $guarded = ['updated_at'];

    protected $dates = [
        'target_close_date', 'activity_date', 'created_at', 'updated_at',
    ];

    protected $casts = [
        'vacant' => 'boolean',
        'foreclosure' => 'boolean',
        'rental' => 'boolean',
    ];

    protected function requiresApprovalWhen(array $modifications): bool
    {
        // Handle some logic that determines if this change requires approval
        //
        // Return true if the model requires approval, return false if it
        // should update immediately without approval.
        return true;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($activity) {
            $cycle = SalesCycle::find($activity->sales_cycle_id);
            $cycle->contact_id = $activity->contact_id;
            $cycle->deal_type = $activity->deal_type;
            $cycle->target_close_date = $activity->target_close_date;
            $cycle->sales_stage = $activity->sales_stage;
            $cycle->programs = $activity->programs;
            $cycle->save();
        });

        static::updating(function ($activity) {
            $cycle = SalesCycle::find($activity->sales_cycle_id);
            $cycle->contact_id = $activity->contact_id;
            $cycle->deal_type = $activity->deal_type;
            $cycle->target_close_date = $activity->target_close_date;
            $cycle->sales_stage = $activity->sales_stage;
            $cycle->programs = $activity->programs;
            $cycle->save();
        });
    }

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logUnguarded = true;

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    //associates community id
    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_id = $this->community_id;
    }

    public function salesCycle()
    {
        return $this->belongsTo(\App\Models\SalesCycle::class, 'sales_cycle_id', 'id');
    }

    public function contact()
    {
        return $this->belongsTo(\App\Models\SalesCycle::class, 'contact_id', 'id');
    }

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'community_id', 'COMMUNITYID');
    }
}
