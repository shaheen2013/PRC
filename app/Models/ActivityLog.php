<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ActivityLog.
 *
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property int|null $subject_id
 * @property string|null $subject_type
 * @property int|null $causer_id
 * @property string|null $causer_type
 * @property string|null $properties
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CMCommunity|null $community
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereCauserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereCauserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereLogName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityLog extends Model
{
    protected $table = 'activity_log';

    protected $connection = 'mysql';

    protected $guarded = [];

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'subject_id', 'COMMUNITYID');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'causer_id', 'id');
    }

    public function convertSubjectToHumanReadable($subject)
    {
        switch ($subject) {
            case \App\Models\CommunitySalesConfiguration::class:
                return 'Sales Configuration';
            case \App\Models\Contact::class:
                return 'People';
            case \App\Models\Contract::class:
                return 'Contract';
            case \App\Models\RelationshipManager::class:
                return 'RM';
            case \App\Models\Interaction::class:
                return 'Interaction';
            case \App\Models\CommunityConfiguration::class:
                return 'Branding Configuration';
            case \App\Models\CommunityMiscConfiguration::class:
                return 'Misc Configuration';
            case \App\Models\CMCommunity::class:
                return 'Misc Configuration';
            case \App\Models\RentalVacantSalesStatus::class:
                return 'Sales Status';
            case \App\Models\CommunityLogo::class:
                return 'Community Logo';
            case \App\Models\CRMCommunitySale::class:
                return ' Sales Status';
            case \App\Models\SalesCycle::class:
                return ' Sales Cycle';
            case \App\Models\SalesActivity::class:
                return ' Sales Activity';
            default:
                return $subject;
                }
    }

    public function translateFieldName($name)
    {
        switch ($name) {
            case 'SALESSTATUSID':
                return 'Foreclosure Status';
            case 'FIELD1':
                return 'Custom Field 1';
            case 'FIELD2':
                return 'Custom Field 2';
            case 'FIELD3':
                return 'Custom Field 3';
            case 'FIELD4':
                return 'Custom Field 4';
            case 'FIELD5':
                return 'Custom Field 5';
            case 'rfp_status':
                return 'RFP Activity';
            default:
                return $name;
        }
    }
}
