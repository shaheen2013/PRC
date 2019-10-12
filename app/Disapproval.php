<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Approval\Models\Disapproval as ModelDisapproval;

class Disapproval extends ModelDisapproval
{
    protected $connection = 'mysql';
}
