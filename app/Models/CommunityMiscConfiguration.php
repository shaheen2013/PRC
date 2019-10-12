<?php

namespace App\Models;

use Approval\Traits\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class CommunityMiscConfiguration extends Model
{
    use LogsActivity;

    protected $primaryKey = 'community_id';

    protected $connection = 'mysql_dev';

    protected $table = 'cm_community_misc_configurations';

    protected $guarded = ['updated_at'];

    protected $casts = [
        'utility_data' => 'boolean',
        'cm_registrations_rental' => 'boolean',
        'cm_registrations_vacant' => 'boolean',
        'cm_registrations_foreclosure' => 'boolean',
    ];

    protected static $logUnguarded = true;

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected function requiresApprovalWhen(array $modifications) : bool
    {
        // Handle some logic that determines if this change requires approval
        //
        // Return true if the model requires approval, return false if it
        // should update immediately without approval.
        return true;
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_id = $this->community_id;
    }

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'COMMUNITYID', 'community_id');
    }
}
