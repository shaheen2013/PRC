<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Approval\Traits\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\CMCommunity.
 *
 * @property int $COMMUNITYID
 * @property int|null $STATEID
 * @property string|null $STATE
 * @property string|null $COUNTY
 * @property string|null $CITY
 * @property string|null $FIELD1
 * @property string|null $FIELD2
 * @property string|null $FIELD3
 * @property string|null $FIELD4
 * @property string|null $FIELD5
 * @property string|null $GROUPEMAIL
 * @property int|null $COMMUNITYSTATUSID
 * @property int|null $COMMUNITYVACANTSTATUSID
 * @property int|null $COMMUNITYRENTALSTATUSID
 * @property int|null $COMMUNITYVACATIONSTATUSID
 * @property string|null $COMMUPDATEDDATE
 * @property string|null $CODE
 * @property int|null $MULTIPLECOMMUNITIES
 * @property int|null $ORDINANCEID
 * @property int|null $RENTALORDINANCEID
 * @property int|null $ISACTIVE
 * @property string|null $ZIPCODES
 * @property string|null $FRIENDLYNAME
 * @property string|null $PRIORIZATIONNOTES
 * @property string|null $FULLNAME
 * @property int|null $NOJURISFLAG
 * @property int|null $PRIMARYCOMMUNITYID
 * @property int|null $RELATEDCOUNTY
 * @property int|null $LASTUPDATEDBY
 * @property int|null $LASTRENTALUPDATEDBY
 * @property \Illuminate\Support\Carbon|null $LASTUPDATEDDATE
 * @property string|null $LASTRENTALUPDATEDDATE
 * @property string|null $LASTSTATUSCHANGEDATE
 * @property string|null $LASTRENTALSTATUSCHANGEDATE
 * @property int|null $ORDER
 * @property int|null $RUNNINGORDINANCEID
 * @property int|null $RUNNINGCOMMUNITYSTATUSID
 * @property int|null $RUNNINGRENTALORDINANCEID
 * @property int|null $RUNNINGCOMMUNITYRENTALSTATUS
 * @property int|null $ENFORCEDELINQUENT
 * @property int|null $ICFLAG
 * @property int|null $SPECIFICMAPSERVICE
 * @property int|null $INTEGRATEDVIOLATIONS
 * @property int|null $INTEGRATEDLIENS
 * @property int|null $DAYSTOCLOSEVILATIONS
 * @property int|null $NOUNINCFLAG
 * @property int|null $APPROVEDFORECLOSUREID
 * @property int|null $APPROVEDFORECLOSURESTATUSID
 * @property int|null $PENDINGFORECLOSUREID
 * @property int|null $PENDINGFORECLOSURESTATUSID
 * @property int|null $HADRENEWALTYPECHANGES
 * @property-read \App\Models\CommunityLogo $communityLogo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @property-read \App\Models\CRMCommunitySale $crmForeclosureSale
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CMRtStatsSummaryHistory[] $foreclosureStats
 * @property-read mixed $est_long_term_rental
 * @property-read mixed $est_short_term_rental
 * @property-read mixed $est_vacant_for_sale
 * @property-read mixed $est_vacant_long_term
 * @property-read mixed $est_vacant_rental
 * @property-read mixed $est_vacant_seasonal
 * @property-read mixed $est_vacant_total
 * @property mixed $foreclosure_sales
 * @property-read mixed $foreclosure_sales_status
 * @property-read mixed $housing_units
 * @property mixed $logo
 * @property-read mixed $rental_sales_status
 * @property-read mixed $sales_status_id
 * @property-read mixed $vacant_sales_status
 * @property-read \App\Models\CommunityQuartile $housingData
 * @property-read \App\Models\RentalVacantSalesStatus $rentalVacantSalesStatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Organization[] $rms
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereAPPROVEDFORECLOSUREID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereAPPROVEDFORECLOSURESTATUSID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereCITY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereCODE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereCOMMUNITYID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereCOMMUNITYRENTALSTATUSID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereCOMMUNITYSTATUSID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereCOMMUNITYVACANTSTATUSID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereCOMMUNITYVACATIONSTATUSID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereCOMMUPDATEDDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereCOUNTY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereDAYSTOCLOSEVILATIONS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereENFORCEDELINQUENT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereFIELD1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereFIELD2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereFIELD3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereFIELD4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereFIELD5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereFRIENDLYNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereFULLNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereGROUPEMAIL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereHADRENEWALTYPECHANGES($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereICFLAG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereINTEGRATEDLIENS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereINTEGRATEDVIOLATIONS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereISACTIVE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereLASTRENTALSTATUSCHANGEDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereLASTRENTALUPDATEDBY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereLASTRENTALUPDATEDDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereLASTSTATUSCHANGEDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereLASTUPDATEDBY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereLASTUPDATEDDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereMULTIPLECOMMUNITIES($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereNOJURISFLAG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereNOUNINCFLAG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereORDER($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereORDINANCEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity wherePENDINGFORECLOSUREID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity wherePENDINGFORECLOSURESTATUSID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity wherePRIMARYCOMMUNITYID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity wherePRIORIZATIONNOTES($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereRELATEDCOUNTY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereRENTALORDINANCEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereRUNNINGCOMMUNITYRENTALSTATUS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereRUNNINGCOMMUNITYSTATUSID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereRUNNINGORDINANCEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereRUNNINGRENTALORDINANCEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereSPECIFICMAPSERVICE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereSTATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereSTATEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMCommunity whereZIPCODES($value)
 * @mixin \Eloquent
 */
class CMCommunity extends Model
{
    use LogsActivity, Searchable;

    public static $perPageViaRelationship = 25;

    protected $guarded = ['updated_at'];

    protected $primaryKey = 'COMMUNITYID';

    protected $connection = 'mysql_dev';

    protected $table = 'osusr_mlv_community';

    public $timestamps = false;

    protected $dates = [
        'BIRTHDATE',
        'LASTUPDATEDDATE',
        'PARTNERDATE',
        'CONTRACTEFFECTIVEDATE',
        'CONTRACTEXPIRATIONDATE',
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

    public function getRentalPartnerStatusAttribute()
    {
        return $this->rentalVacantSalesStatus ? $this->rentalVacantSalesStatus->rental_partner_status : false;
    }

    public function getVacantPartnerStatusAttribute()
    {
        return $this->rentalVacantSalesStatus ? $this->rentalVacantSalesStatus->vacant_partner_status : false;
    }

    public function getForeclosurePartnerStatusAttribute()
    {
        return $this->rentalVacantSalesStatus ? $this->rentalVacantSalesStatus->foreclosure_partner_status : false;
    }

    public function salesActivities()
    {
        return $this->hasMany(\App\Models\SalesActivity::class, 'community_id', 'COMMUNITYID');
    }

    public function salesCycles()
    {
        return $this->hasMany(\App\Models\SalesCycle::class, 'community_id', 'COMMUNITYID');
    }

    public function hasCustomName()
    {
        return ($this->miscConfiguration ? $this->miscConfiguration->custom_friendly_name : false) ? true : false;
    }

    public function getCustomFriendlyNameAttribute()
    {
        return $this->miscConfiguration ? $this->miscConfiguration->friendly_name : $this->FRIENDLYNAME;
    }

    public function modifications()
    {
        return $this->hasMany(\App\Modification::class, 'community_id', 'COMMUNITYID');
    }

    public function pendingModifications()
    {
        return $this->hasMany(\App\Modification::class, 'community_id', 'COMMUNITYID')->where('active', 1);
    }

    public function activityLogs()
    {
        return $this->hasMany(\App\Models\ActivityLog::class, 'subject_id', 'COMMUNITYID');
    }

    public function contacts()
    {
        return $this->hasMany(\App\Models\Contact::class, 'community_id', 'COMMUNITYID');
    }

    public function relationshipManagers()
    {
        return $this->belongsToMany(\App\Models\RelationshipManager::class, 'cm_community_rm', 'community_id', 'relationship_manager_id');
    }

    public function state()
    {
        return $this->hasOne(\App\Models\State::class, 'code', 'STATE');
    }

    public function brandingConfiguration()
    {
        return $this->hasOne(\App\Models\CommunityConfiguration::class, 'community_id', 'COMMUNITYID');
    }

    public function miscConfiguration()
    {
        return $this->hasOne(\App\Models\CommunityMiscConfiguration::class, 'community_id', 'COMMUNITYID');
    }

    public function contracts()
    {
        return $this->hasMany(\App\Models\Contract::class, 'community_id', 'COMMUNITYID');
    }

    public function getExcludedAttribute()
    {
        return $this->salesConfiguration ? $this->salesConfiguration->excluded : null;
    }

    public function getStateGovernanceAttribute()
    {
        return $this->salesConfiguration ? $this->salesConfiguration->state_governance : null;
    }

    public function getStateForeclosureProcessAttribute()
    {
        return $this->salesConfiguration ? $this->salesConfiguration->state_foreclosure_process : null;
    }

    public function getStrongMayorAttribute()
    {
        return $this->salesConfiguration ? $this->salesConfiguration->strong_mayor : null;
    }

    public function salesConfiguration()
    {
        return $this->hasOne(\App\Models\CommunitySalesConfiguration::class, 'community_id', 'COMMUNITYID');
    }

    public function getRelationshipStatusAttribute()
    {
        return $this->salesConfiguration ? ($this->salesConfiguration->relationshipStatus ? $this->salesConfiguration->relationshipStatus->status : null) : null;
    }

    public function getRentalSalesStatusAttribute()
    {
        return $this->rentalVacantSalesStatus ? $this->rentalVacantSalesStatus->rental_status : 1;
    }

    public function getActiveForeclosuresAttribute()
    {
        return number_format($this->foreclosureStats->where('ISMOSTCURRENT', 1)->first() ?
            $this->foreclosureStats->where('ISMOSTCURRENT', 1)->first()->FORECLOSURESACTIVE : null);
    }

    public function getVacantSalesStatusAttribute()
    {
        return $this->rentalVacantSalesStatus ? $this->rentalVacantSalesStatus->vacant_status : 1;
    }

    public function rentalVacantSalesStatus()
    {
        return $this->hasOne(\App\Models\RentalVacantSalesStatus::class, 'community_id', 'COMMUNITYID');
    }

    public function foreclosureStats()
    {
        return $this->hasMany(\App\Models\CMRtStatsSummaryHistory::class, 'COMMCOMMUNITYID', 'COMMUNITYID');
    }

    public function communityLogo()
    {
        return $this->hasOne(\App\Models\CommunityLogo::class, 'community_id', 'COMMUNITYID');
    }

    public function configuration()
    {
        return $this->hasOne(\App\Models\CommunityConfiguration::class, 'community_id', 'COMMUNITYID');
    }

    public function housingData()
    {
        return $this->hasOne(\App\Models\CommunityQuartile::class, 'community_id', 'COMMUNITYID');
    }

    public function interactions()
    {
        return $this->hasMany(\App\Models\Interaction::class, 'community_id', 'COMMUNITYID');
    }

    public function getForeclosureSalesStatusAttribute()
    {
        return $this->housingData ? $this->housingData->Quartile_Label : 'X-Small';
    }

    public function getHousingUnitsAttribute()
    {
        return $this->housingData ? $this->housingData->housing_units : 'Not Available';
    }

    public function getEstShortTermRentalAttribute()
    {
        return $this->housingData ? $this->housingData->est_short_term_rental : 'Not Available';
    }

    public function getEstLongTermRentalAttribute()
    {
        return $this->housingData ? $this->housingData->est_long_term_rental : 'Not Available';
    }

    public function getEstVacantTotalAttribute()
    {
        return $this->housingData ? $this->housingData->est_vacant_total : 'Not Available';
    }

    public function getEstVacantRentalAttribute()
    {
        return $this->housingData ? $this->housingData->est_vacant_rental : 'Not Available';
    }

    public function getEstVacantForSaleAttribute()
    {
        return $this->housingData ? $this->housingData->est_vacant_for_sale : 'Not Available';
    }

    public function getEstVacantSeasonalAttribute()
    {
        return $this->housingData ? $this->housingData->est_vacant_seasonal : 'Not Available';
    }

    public function getEstVacantLongTermAttribute()
    {
        return $this->housingData ? $this->housingData->est_vacant_long_term : 'Not Available';
    }



    public function crmForeclosureSale()
    {
        return $this->hasOne(\App\Models\CRMCommunitySale::class, 'COMMUNITYID', 'COMMUNITYID');
    }

//
    public function crm()
    {
        return $this->hasOne(\App\Models\CRMCommunitySale::class, 'COMMUNITYID', 'COMMUNITYID');
    }

    public function getSalesStatusIdAttribute()
    {
        return $this->crmForeclosureSale ? $this->crmForeclosureSale->SALESSTATUSID : 1;
    }

    public function getForeclosureSalesAttribute()
    {
        // Don't forget to check the relation here if you don't want any error on Nova.
        return $this->crmForeclosureSale ? $this->crmForeclosureSale->SALESSTATUSID : null;
    }

    public function setForeclosureSalesAttribute($value)
    {
        $status = $this->crmForeclosureSale;
        $status->fill(['SALESSTATUSID' => $value]);
        $status->save();
    }

    public function getLogoAttribute()
    {
        // Don't forget to check the relation here if you don't want any error on Nova.
        return $this->communityLogo ? $this->communityLogo->logo : null;
    }

    public function setLogoAttribute($value)
    {
        $logo = $this->communityLogo ?: new CommunityLogo;
        $logo->logo = $value;
        $logo->community_id = $this->id;
        $this->communityLogo()->save($logo);
    }

    public function convertSalesStatusId($id)
    {
        switch ($id) {
            case 0:
                return 0;
            case 1:
                return 0;
            case 5:
                return 5;
            case 6:
                return 4;
            case 10:
                return 0;
            case 11:
                return 2;
            case 12:
                return 3;
            case 13:
                return 1;
            case 14:
                return 6;
            default:
                return 0;
        }
    }
}
