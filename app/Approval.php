<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Approval\Models\Approval as ModelApproval;

class Approval extends ModelApproval
{
    protected $connection = 'mysql';
}
