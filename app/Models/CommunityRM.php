<?php

namespace App\Models;

use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\RelationshipManager.
 *
 * @property int $id
 * @property int $community_id
 * @property int $organization_id
 * @property int|null $county_id
 * @property int $secondary_rm
 * @property float $rm_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CMCommunity[] $communities
 * @property-read \App\Organization $organization
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RelationshipManager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RelationshipManager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RelationshipManager query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RelationshipManager whereCommunityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RelationshipManager whereCountyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RelationshipManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RelationshipManager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RelationshipManager whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RelationshipManager whereRmAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RelationshipManager whereSecondaryRm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RelationshipManager whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CommunityRM extends Pivot
{
    use LogsActivity;

    public $incrementing = true;

    protected $connection = 'mysql_dev';

    protected $table = 'cm_community_rm';

    protected $guarded = [];

    protected static $logUnguarded = true;

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_id = $this->community_id;
    }
}
