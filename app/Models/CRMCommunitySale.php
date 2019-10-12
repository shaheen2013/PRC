<?php

namespace App\Models;

use Approval\Traits\RequiresApproval;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\CRMCommunitySale.
 *
 * @property int $COMMUNITYID
 * @property int|null $SALESSTATUSID
 * @property string|null $ENGAGEDDATE
 * @property string|null $ONBOARDINGFUTUREDATE
 * @property string|null $PARTNERDATE
 * @property float|null $CCCAMOUNT
 * @property int|null $REMITTANCEPERIOD
 * @property string|null $CONTRACTEFFECTIVEDATE
 * @property string|null $CONTRACTEXPIRATIONDATE
 * @property int|null $SURVIVALPROVISION
 * @property int|null $CONTRACTATTACHMENT
 * @property string|null $CONTRACTTERM
 * @property int|null $LASTUPDATEDBY
 * @property string|null $LASTUPDATEDDATE
 * @property string|null $NONENOTES
 * @property int|null $ORDINANCEALREADYBEENPASSED
 * @property int|null $ISTHEREREGISTRATIONFEE
 * @property int|null $REGISTRATIONFEE
 * @property int|null $REMITTANCEEDITLOCKED
 * @property int|null $RMNOVALUEDEFINED
 * @property int|null $ONBOARDING
 * @property string|null $ONBOARDINGTARGETDATE
 * @property int|null $ORDINANCE_CHECK
 * @property int|null $CONTRACT_CHECK
 * @property int|null $DATA_CHECK
 * @property int|null $CMREGISTRATIONS_CHECK
 * @property string|null $NOTES
 * @property string|null $PROSPECTDATE
 * @property string|null $TARGET1DATE
 * @property string|null $ONNOINTERESTDATE
 * @property string|null $TARGET2DATE
 * @property string|null $TARGET3DATE
 * @property string|null $TARGETDATEEND
 * @property int|null $ISACTIVE
 * @property string|null $HUBSPOTDEALID
 * @property int|null $SHAREPOINTDOC
 * @property int|null $SHAREPOINTDOCID
 * @property string|null $SHAREPOINTDOCNAME
 * @property-read \App\Models\CMCommunity $community
 * @property-read \App\Models\CRMSalesStatus|null $salesStatus
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereCCCAMOUNT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereCMREGISTRATIONSCHECK($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereCOMMUNITYID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereCONTRACTATTACHMENT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereCONTRACTCHECK($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereCONTRACTEFFECTIVEDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereCONTRACTEXPIRATIONDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereCONTRACTTERM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereDATACHECK($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereENGAGEDDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereHUBSPOTDEALID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereISACTIVE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereISTHEREREGISTRATIONFEE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereLASTUPDATEDBY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereLASTUPDATEDDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereNONENOTES($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereNOTES($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereONBOARDING($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereONBOARDINGFUTUREDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereONBOARDINGTARGETDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereONNOINTERESTDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereORDINANCEALREADYBEENPASSED($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereORDINANCECHECK($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale wherePARTNERDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale wherePROSPECTDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereREGISTRATIONFEE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereREMITTANCEEDITLOCKED($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereREMITTANCEPERIOD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereRMNOVALUEDEFINED($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereSALESSTATUSID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereSHAREPOINTDOC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereSHAREPOINTDOCID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereSHAREPOINTDOCNAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereSURVIVALPROVISION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereTARGET1DATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereTARGET2DATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereTARGET3DATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMCommunitySale whereTARGETDATEEND($value)
 * @mixin \Eloquent
 */
class CRMCommunitySale extends Model
{
    use LogsActivity;

    protected $primaryKey = 'COMMUNITYID';

    protected $connection = 'mysql_dev';

    protected $table = 'osusr_tvl_crm';

    const UPDATED_AT = 'LASTUPDATEDDATE';

    protected $guarded = ['LASTUPDATEDDATE'];

    protected static $ignoreChangedAttributes = ['LASTUPDATEDDATE'];

    protected static $logUnguarded = true;

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

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
        $activity->subject_id = $this->COMMUNITYID;
    }

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'COMMUNITYID', 'COMMUNITYID');
    }

    public function salesStatus()
    {
        return $this->belongsTo(\App\Models\CRMSalesStatus::class, 'SALESSTATUSID');
    }
}
