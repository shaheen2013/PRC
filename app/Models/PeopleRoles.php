<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PeopleRoles extends Model
{
    use LogsActivity;

    protected $connection = 'mysql_dev';

    protected $table = 'cm_peoples_roles';

    public function people()
    {
        return $this->belongsToMany(\App\Models\Contact::class, 'cm_contact_role', 'role_id', 'contact_id');
    }
}
