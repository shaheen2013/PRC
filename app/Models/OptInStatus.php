<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptInStatus extends Model
{
    protected $connection = 'mysql_dev';

    protected $table = 'cm_opt_in_statuses';

    protected $guarded = [];

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'opt_in_status', 'id');
    }

    public function allOptions()
    {
        return [
            1 => 'State',
            2 => 'County',
        ];
    }

    public function convertIdToStatus($id)
    {
        switch ($id) {
            case 1:
                return 'State';
            case 2:
                return 'County';
            default:
                return $id;
        }
    }
}
