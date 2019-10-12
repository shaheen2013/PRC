<?php

namespace App\Models;

use Approval\Traits\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class CommunitySalesConfiguration extends Model
{
    use LogsActivity;

    protected $primaryKey = 'community_id';

    protected $connection = 'mysql_dev';

    protected $table = 'cm_community_sales_configurations';

    protected $guarded = ['updated_at'];

    protected $casts = [
        'strong_mayor' => 'boolean',
        'excluded' => 'boolean',
        'special_oversight' => 'boolean',
        'relationship_status' => 'integer',
        'home_rule' => 'boolean',
        'state_foreclosure_process' => 'boolean',
        'rfp_status' => 'boolean',
        'key_policy_agreement' => 'boolean',
        'remittance_email_required' => 'boolean',
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
        return $this->belongsTo(\App\Models\CMCommunity::class, 'community_id', 'COMMUNITYID');
    }

    public function relationshipStatus()
    {
        return $this->hasOne(\App\Models\RelationshipStatus::class, 'id', 'relationship_status');
    }

    public function convertIdToRelationshipStatus($id)
    {
        switch ($id) {
            case 1:
                return 'Red';
            case 2:
                return 'Yellow';
            case 3:
                return 'Green';
            default:
                return 'Unknown';
        }
    }
}
