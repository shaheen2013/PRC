<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViolationConfiguration extends Model
{
    protected $connection = 'mysql_dev';

    protected $table = 'cm_onboarding_statuses';

    protected $guarded = [];

    public function allOptions()
    {
        return [
            1 => 'Automated',
            2 => 'Manual',
        ];
    }

    public function convertIdToStatus($id)
    {
        switch ($id) {
            case 1:
                return 'Automated';
            case 2:
                return 'Manual';
            default:
                return $id;
        }
    }
}
