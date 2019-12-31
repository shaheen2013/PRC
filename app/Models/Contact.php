<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Approval\Traits\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Contact.
 *
 * @property int $id
 * @property int|null $contactmgmt_id
 * @property int|null $organization_id
 * @property int|null $community_id
 * @property string|null $sharpspring_id
 * @property int|null $govtype
 * @property string $email
 * @property string|null $title
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $suffix
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property string|null $primary_phone
 * @property string|null $primary_phone_ext
 * @property string|null $secondary_phone
 * @property string|null $secondary_phone_ext
 * @property string|null $company_name
 * @property string|null $description
 * @property string|null $facebook
 * @property string|null $fax
 * @property string|null $website
 * @property string|null $name_of_community_SS
 * @property int|null $weighted_lead_score_SS
 * @property \Illuminate\Support\Carbon|null $update_timestamp_SS
 * @property string|null $persona_SS
 * @property string|null $county_SS
 * @property string|null $lead_status_SS
 * @property string|null $linkedin
 * @property string|null $street
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zipcode
 * @property string|null $country
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\CMCommunity|null $community
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Interaction[] $interactions
 * @property-read \App\Models\Organization|null $organization
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCommunityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereContactmgmtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCountySS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereGovtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereLeadStatusSS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereNameOfCommunitySS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact wherePersonaSS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact wherePrimaryPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact wherePrimaryPhoneExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereSecondaryPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereSecondaryPhoneExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereSharpspringId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereUpdateTimestampSS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereWeightedLeadScoreSS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereZipcode($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
//    use Actionable;
    use Searchable;
    use LogsActivity;
    use RequiresApproval;

    protected $connection = 'mysql_dev';

    protected $table = 'cm_contacts';

    protected $guarded = ['updated_at'];

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logUnguarded = true;

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;


    protected $approversRequired = 1;
    protected $disapproversRequired = 1;
    protected $updateWhenApproved = true;
    protected $deleteWhenDisapproved = false;
    protected $deleteWhenApproved = true;

    protected function requiresApprovalWhen(array $modifications) : bool
    {
        // Handle some logic that determines if this change requires approval
        //
        // Return true if the model requires approval, return false if it
        // should update immediately without approval.
        return true;
    }

    public function allOptionsByCommunity($id)
    {
        return CMCommunity::find($id)->contacts;
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_id = $this->community_id;
    }

    public function roles()
    {
        return $this->belongsToMany(\App\Models\PeopleRoles::class, 'cm_contact_role', 'contact_id', 'role_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'community_id', 'COMMUNITYID');
    }

    public function interactions()
    {
        return $this->belongsToMany(\App\Models\Interaction::class, 'cm_contact_interaction')->withTimestamps();
    }

    public function salesCycles()
    {
        return $this->hasMany(\App\Models\SalesCycle::class, 'contact_id', 'id');
    }

    public function getIsRemittanceContactAttribute()
    {
        return $this->roles->where('id', 1)->count() > 0;
    }
}
