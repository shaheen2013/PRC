<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateForeclosureProcessConfig extends Model
{
    protected $connection = 'mysql_dev';

    protected $table = 'cm_state_foreclosure_process_configs';

    protected $guarded = [];

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'state_foreclosure_process', 'id');
    }

    public function allOptions()
    {
        return [
            1 => 'Judicial',
            2 => 'Non-Judicial',
        ];
    }
}
