<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CMCommunity[] $communities
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
class RelationshipManager extends Model
{
    protected $connection = 'mysql_dev';

    protected $table = 'cm_relationship_managers';

    protected $guarded = ['updated_at'];

    protected static $logUnguarded = true;

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    protected static $ignoreChangedAttributes = ['updated_at'];

    public function communities()
    {
        return $this->belongsToMany(\App\Models\CMCommunity::class, 'cm_community_rm', 'relationship_manager_id', 'community_id');
    }
}
