<?php

namespace App\Models;

use Approval\Traits\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\RentalVacantSalesStatus.
 *
 * @property int $id
 * @property int $community_id
 * @property int $vacant_status
 * @property int $rental_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CMCommunity $community
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalVacantSalesStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalVacantSalesStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalVacantSalesStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalVacantSalesStatus whereCommunityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalVacantSalesStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalVacantSalesStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalVacantSalesStatus whereRentalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalVacantSalesStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RentalVacantSalesStatus whereVacantStatus($value)
 * @mixin \Eloquent
 */
class RentalVacantSalesStatus extends Model
{
    use LogsActivity;

    protected $connection = 'mysql_dev';

    protected $table = 'cm_rental_vacant_sales_statuses';

    protected $guarded = ['updated_at'];

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logUnguarded = true;

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    protected $casts = [
        'community_id' => 'integer',
        'vacant_status' => 'integer',
        'rental_status' => 'integer',
        'rental_partner_status' => 'boolean',
        'vacant_partner_status' => 'boolean',
        'foreclosure_partner_status' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Function that defines the rule of when an approval process
     * should be actioned for this model.
     *
     * @param array $modifications
     *
     * @return bool
     */
    protected function requiresApprovalWhen(array $modifications) : bool
    {
        // Handle some logic that determines if this change requires approval
        //
        // Return true if the model requires approval, return false if it
        // should update immediately without approval.
        return false;
    }

    public function community()
    {
        return $this->hasOne(\App\Models\CMCommunity::class, 'COMMUNITYID', 'community_id');
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_id = $this->community_id;
    }

    public function allOptions()
    {
        return [
            1 => '0 - No Activity',
            13 => '1 - Generate',
            11 => '2 - Guide',
            12 => '3 - Propose',
            6 => '4 - Onboard',
            5 => '5 - Enhance',
            14 => '6 - Upgrade',
        ];
    }

    public function convertIdToSalesStatus($id)
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
