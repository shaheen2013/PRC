<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SalesStatus.
 *
 * @property int $id
 * @property string $label
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CRMCommunitySale[] $OUTcommunities
 * @property-read mixed $sales_status_label
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesStatus whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SalesStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SalesStatus extends Model
{
    protected $connection = 'mysql';

    public function OUTcommunities()
    {
        return $this->hasMany(\App\Models\CRMCommunitySale::class, 'SALESSTATUSID');
    }

    public function getSalesStatusLabelAttribute()
    {
        return $this->label;
    }
}
