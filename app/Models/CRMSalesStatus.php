<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CRMSalesStatus.
 *
 * @property int $ID
 * @property string|null $LABEL
 * @property int|null $ORDER
 * @property int|null $IS_ACTIVE
 * @property string|null $CLASS
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CRMCommunitySale[] $communities
 * @property-read mixed $sales_status_label
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMSalesStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMSalesStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMSalesStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMSalesStatus whereCLASS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMSalesStatus whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMSalesStatus whereISACTIVE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMSalesStatus whereLABEL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CRMSalesStatus whereORDER($value)
 * @mixin \Eloquent
 */
class CRMSalesStatus extends Model
{
    protected $connection = 'mysql_dev';

    protected $table = 'osusr_tvl_salesstatus';

    public function communities()
    {
        return $this->hasMany(\App\Models\CRMCommunitySale::class, 'SALESSTATUSID');
    }

    public function getSalesStatusLabelAttribute()
    {
        return $this->LABEL;
    }

    public function allOptions()
    {
        return [
            1 => 'No Activity',
            5 => 'Enhance',
            6 => 'Onboard',
            7 => 'Generate',
            10 => 'No Interest',
            11 => 'Guide',
            12 => 'Propose',
            13 => 'Generate',
        ];
    }
}
