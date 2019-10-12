<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CMOtr.
 *
 * @property int $ID
 * @property string|null $PROPERTYID
 * @property int|null $JURISDICTIONID
 * @property int|null $OBLIGATIONNO
 * @property string|null $STARTDATE
 * @property int|null $STARTROLEID
 * @property int|null $STARTREASONID
 * @property string|null $CLOSEDATE
 * @property int|null $ENDROLEID
 * @property int|null $CLOSEREASONID
 * @property int|null $ENDINITIATEDBY
 * @property int|null $PROPERTYEVIDENCEID_START
 * @property int|null $PROPERTYEVIDENCEID_END
 * @property int|null $OMTORGID
 * @property int|null $AMSORGID
 * @property int|null $RGORGID
 * @property int|null $PMORGID
 * @property int|null $LSORGID
 * @property int|null $PMCONTACTID
 * @property int|null $LSCONTACTID
 * @property int|null $FEECOMPLIANCEID
 * @property string|null $FEECOMPLIANCEDATE
 * @property int|null $DATACOMPLIANCEID
 * @property string|null $DATACOMPLIANCEDATE
 * @property string|null $LASTREVIEWDATE
 * @property int|null $GOVTFORECLOSURESTATUS
 * @property int|null $GOVTOCCUPANCYSTATUS
 * @property string|null $GOVTLASTINSPECTIONDATE
 * @property int|null $SERVICERFORECLOSURESTATUS
 * @property int|null $SERVICEROCCUPANCYSTATUS
 * @property string|null $SERVICERLASTINSPECTIONDATE
 * @property int|null $REGISTRYAGENCYID
 * @property int|null $RGASSIGNED
 * @property int|null $CCHAMPCONFIRMATIONSTATUSID
 * @property string|null $CCHAMPCONFIRMATIONDATE
 * @property int|null $RPCONFIRMATIONSTATUSID
 * @property string|null $RPCONFIRMATIONDATE
 * @property int|null $REGISTRATIONTYPEID
 * @property int|null $ACTIVE
 * @property int|null $CREATEDBY
 * @property string|null $CREATEDDATE
 * @property int|null $UPDATEDBY
 * @property string|null $UPDATEDDATE
 * @property int|null $STARTEDBYCONTACTID
 * @property int|null $STARTEDBYORGID
 * @property int|null $ENDEDBYCONTACTID
 * @property int|null $ENDEDBYORGID
 * @property string|null $OMTCHANGEDATE
 * @property float|null $BALANCEDUE
 * @property int|null $COMMUNITYID
 * @property-read \App\Models\CMCommunity|null $community
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereACTIVE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereAMSORGID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereBALANCEDUE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereCCHAMPCONFIRMATIONDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereCCHAMPCONFIRMATIONSTATUSID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereCLOSEDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereCLOSEREASONID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereCOMMUNITYID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereCREATEDBY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereCREATEDDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereDATACOMPLIANCEDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereDATACOMPLIANCEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereENDEDBYCONTACTID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereENDEDBYORGID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereENDINITIATEDBY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereENDROLEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereFEECOMPLIANCEDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereFEECOMPLIANCEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereGOVTFORECLOSURESTATUS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereGOVTLASTINSPECTIONDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereGOVTOCCUPANCYSTATUS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereJURISDICTIONID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereLASTREVIEWDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereLSCONTACTID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereLSORGID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereOBLIGATIONNO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereOMTCHANGEDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereOMTORGID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr wherePMCONTACTID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr wherePMORGID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr wherePROPERTYEVIDENCEIDEND($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr wherePROPERTYEVIDENCEIDSTART($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr wherePROPERTYID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereREGISTRATIONTYPEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereREGISTRYAGENCYID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereRGASSIGNED($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereRGORGID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereRPCONFIRMATIONDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereRPCONFIRMATIONSTATUSID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereSERVICERFORECLOSURESTATUS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereSERVICERLASTINSPECTIONDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereSERVICEROCCUPANCYSTATUS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereSTARTDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereSTARTEDBYCONTACTID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereSTARTEDBYORGID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereSTARTREASONID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereSTARTROLEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereUPDATEDBY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CMOtr whereUPDATEDDATE($value)
 * @mixin \Eloquent
 */
class CMOtr extends Model
{
    protected $primaryKey = 'ID';

    protected $connection = 'mysql_dev';

    protected $table = 'osusr_qp0_registrationobligation';

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'COMMUNITYID', 'COMMUNITYID');
    }
}
