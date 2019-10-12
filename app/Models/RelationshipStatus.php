<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationshipStatus extends Model
{
    protected $connection = 'mysql_dev';

    protected $table = 'cm_relationship_statuses';

    protected $guarded = [];

    public function community()
    {
        return $this->belongsTo(\App\Models\CommunitySalesConfiguration::class, 'relationship_status', 'id');
    }

    public function allOptions()
    {
        return [
            1 => 'Red',
            2 => 'Yellow',
            3 => 'Green',
        ];
    }

    public function convertIdToStatus($id)
    {
        switch ($id) {
            case 1:
                return 'Red';
            case 2:
                return 'Yellow';
            case 3:
                return 'Green';
            default:
                return $id;
        }
    }
}
