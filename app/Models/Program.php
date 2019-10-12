<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $connection = 'mysql_dev';

    protected $table = 'cm_programs';

    protected $guarded = [];

    public function allOptions()
    {
        return [
            1 => 'Rental',
            2 => 'Vacant',
            3 => 'Foreclosure',
        ];
    }
}
