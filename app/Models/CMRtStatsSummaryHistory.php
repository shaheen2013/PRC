<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CMRtStatsSummaryHistory.
 *
 * @property int $ID
 * @property int|null $COMMCOMMUNITYID
 * @property int|null $COUNTYCOMMUNITYID
 * @property int|null $COMMSTATEID
 * @property string|null $FILINGSTARTDATE
 * @property string|null $FILINGENDDATE
 * @property string|null $UPDATEDON
 * @property int|null $FORECLOSURESTOTAL
 * @property int|null $FORECLOSURESSOLD
 * @property int|null $FORECLOSURESEXPIRED
 * @property int|null $FORECLOSURESACTIVE
 * @property string|null $IMPORTDATE
 * @property string|null $ANALYSISDATE
 * @property int|null $ISMOSTCURRENT
 * @property int|null $ORDINANCEID
 * @property int|null $FORECLOSURESPOTENTIAL
 * @property-read \App\Models\CMCommunity $community
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereANALYSISDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereCOMMCOMMUNITYID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereCOMMSTATEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereCOUNTYCOMMUNITYID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereFILINGENDDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereFILINGSTARTDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereFORECLOSURESACTIVE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereFORECLOSURESEXPIRED($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereFORECLOSURESPOTENTIAL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereFORECLOSURESSOLD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereFORECLOSURESTOTAL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereIMPORTDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereISMOSTCURRENT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereORDINANCEID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CMRtStatsSummaryHistory whereUPDATEDON($value)
 * @mixin \Eloquent
 */
class CMRtStatsSummaryHistory extends Model
{
    protected $primaryKey = 'ID';

    protected $connection = 'mysql_dev';

    protected $table = 'OSUSR_tvl_RTStatsSummaryHistory';

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'COMMUNITYID', 'COMMCOMMUNITYID');
    }
}
