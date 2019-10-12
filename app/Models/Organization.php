<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Organization.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $zipcode
 * @property string|null $state
 * @property string|null $city
 * @property string|null $website
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\OrganizationType $type
 * @property int|null $default_jurisdiction
 * @property int $confirmed
 * @property int $all_communities
 * @property int $archived
 * @property int $weekly_notification
 * @property int $is_trustee
 * @property int $extended_registration_export
 * @property string|null $role_omt_date
 * @property string|null $role_ams_date
 * @property \Illuminate\Support\Carbon|null $role_omt_status
 * @property \Illuminate\Support\Carbon|null $role_ams_status
 * @property string|null $role_omt_confirmed_date
 * @property string|null $role_ams_confirmed_date
 * @property int|null $role_omt_approved_by
 * @property int|null $role_ams_approved_by
 * @property int $onboarded
 * @property int|null $onboarded_by
 * @property int|null $parent_org
 * @property int $locked_contacts
 * @property int $keyrg
 * @property float|null $dpp_limit
 * @property int $government_entity
 * @property int|null $role_omt_rg_assigned
 * @property float|null $invoice_limit
 * @property int $block_notifications
 * @property string|null $block_notifications_at
 * @property int|null $block_notifications_updated_by
 * @property int $tax_lien_purchaser
 * @property int $is_offline_org_rp_initiative_chat
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereAllCommunities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereArchived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereBlockNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereBlockNotificationsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereBlockNotificationsUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereDefaultJurisdiction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereDppLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereExtendedRegistrationExport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereGovernmentEntity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereInvoiceLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereIsOfflineOrgRpInitiativeChat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereIsTrustee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereKeyrg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereLockedContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereOnboarded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereOnboardedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereParentOrg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereRoleAmsApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereRoleAmsConfirmedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereRoleAmsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereRoleAmsStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereRoleOmtApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereRoleOmtConfirmedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereRoleOmtDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereRoleOmtRgAssigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereRoleOmtStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereTaxLienPurchaser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereWeeklyNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereZipcode($value)
 * @mixin \Eloquent
 */
class Organization extends Model
{
    public function contacts()
    {
        return $this->hasMany(\App\Models\Contact::class);
    }

    public function type()
    {
        return $this->hasOne(\App\Models\OrganizationType::class, 'type', 'id');
    }
}
