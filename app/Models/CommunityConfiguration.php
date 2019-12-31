<?php

namespace App\Models;

use Approval\Traits\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\CommunityConfiguration.
 *
 * @property int $community_id
 * @property string|null $compliance_warning_url
 * @property string|null $compliance_warning_email
 * @property string|null $compliance_warning_phone
 * @property string|null $compliance_warning_phone_ext
 * @property string|null $program_page_rental_url
 * @property string|null $program_page_vacant_url
 * @property string|null $program_page_foreclosure_url
 * @property string|null $program_page_registration_url
 * @property string|null $program_page_content_rental
 * @property string|null $program_page_content_vacant
 * @property string|null $program_page_content_foreclosure
 * @property string|null $landing_page_content_rental_vacant_foreclosure
 * @property string|null $landing_page_content_vacant_foreclosure
 * @property string|null $landing_page_content_rental_vacant
 * @property string|null $program_intro_message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CMCommunity $community
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereCommunityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereComplianceWarningEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereComplianceWarningPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereComplianceWarningPhoneExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereComplianceWarningUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereLandingPageContentRentalVacant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereLandingPageContentRentalVacantForeclosure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereLandingPageContentVacantForeclosure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereProgramIntroMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereProgramPageContentForeclosure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereProgramPageContentRental($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereProgramPageContentVacant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereProgramPageForeclosureUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereProgramPageRegistrationUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereProgramPageRentalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereProgramPageVacantUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommunityConfiguration whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CommunityConfiguration extends Model
{
    use LogsActivity, RequiresApproval;

//    protected $casts = [
//        'strong_mayor' => 'boolean',
//        'excluded' => 'boolean'
//    ];
    protected $primaryKey = 'community_id';

    protected $connection = 'mysql_dev';

    protected $table = 'cm_community_branding_configurations';

    protected $guarded = [];

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
        return$this->belongsTo(\App\Models\CMCommunity::class, 'COMMUNITYID', 'community_id');
    }
}
