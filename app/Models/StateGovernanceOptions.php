<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateGovernanceOptions extends Model
{
    protected $connection = 'mysql_dev';

    protected $table = 'cm_state_governance_options';

    protected $guarded = [];

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'state_governance', 'id');
    }

    public function allOptions()
    {
        return [
            1 => 'Home Rule',
            2 => "Dillon's Rule",
        ];
    }
}
