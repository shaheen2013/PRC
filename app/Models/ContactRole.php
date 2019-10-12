<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ContactRole extends Pivot
{
    protected $connection = 'mysql_dev';

    protected $table = 'cm_contact_role';
}
