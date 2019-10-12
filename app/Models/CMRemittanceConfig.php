<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMRemittanceConfig extends Model
{
    protected $primaryKey = 'ID';

    protected $connection = 'mysql_dev';

    protected $table = 'osusr_qp0_remittanceamountconfig';

    public $timestamps = false;

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'COMMUNITYID', 'COMMUNITYID');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\CRMCategory::class, 'CATEGORYID', 'ID');
    }
}
