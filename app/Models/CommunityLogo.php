<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\CommunityLogo.
 *
 * @property int $id
 * @property int $community_id
 * @property string $logo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CMCommunity $community
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityLogo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityLogo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityLogo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityLogo whereCommunityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityLogo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityLogo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityLogo whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityLogo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CommunityLogo extends Model
{
    use LogsActivity;

    protected $connection = 'mysql_dev';

    protected $table = 'cm_community_logos';

    protected $guarded = ['updated_at'];

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logUnguarded = true;

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_id = $this->community_id;
    }

    public function community()
    {
        return $this->hasOne(\App\Models\CMCommunity::class, 'COMMUNITYID', 'community_id');
    }
}
