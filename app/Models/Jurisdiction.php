<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Jurisdiction.
 *
 * @property int $id
 * @property float|null $ordinance_amount
 * @property string|null $ordinance_pass_date
 * @property int|null $renewal_policy
 * @property int|null $active
 * @property int|null $local_agent_service
 * @property int|null $community_org
 * @property string|null $matched_owner_name_date
 * @property string|null $clerk_event_date
 * @property string|null $sale_event_date
 * @property int|null $private_owner_registration
 * @property int|null $private_renewal_policy
 * @property int|null $private_occupancy_policy
 * @property int|null $delist_loan_bc
 * @property int|null $delist_loan_paid_off
 * @property int|null $delist_loan_m
 * @property int|null $delist_sale_third_party
 * @property int|null $delist_sale_loan
 * @property int|null $delist_sale_of_servicing
 * @property int|null $delist_occupancy
 * @property int|null $delist_bank_owned
 * @property int|null $delist_other
 * @property int $community_id
 * @property string|null $active_date
 * @property int|null $active_for_registrations
 * @property string|null $active_for_registrations_date
 * @property int|null $active_vacant_registration
 * @property string|null $active_vacant_registration_date
 * @property int|null $active_rental_registration
 * @property string|null $active_rental_registration_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereActiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereActiveForRegistrations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereActiveForRegistrationsDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereActiveRentalRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereActiveRentalRegistrationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereActiveVacantRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereActiveVacantRegistrationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereClerkEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereCommunityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereCommunityOrg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereDelistBankOwned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereDelistLoanBc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereDelistLoanM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereDelistLoanPaidOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereDelistOccupancy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereDelistOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereDelistSaleLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereDelistSaleOfServicing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereDelistSaleThirdParty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereLocalAgentService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereMatchedOwnerNameDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereOrdinanceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereOrdinancePassDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction wherePrivateOccupancyPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction wherePrivateOwnerRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction wherePrivateRenewalPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereRenewalPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereSaleEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Jurisdiction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Jurisdiction extends Model
{
    //
}
