<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\OrganizationRoleStatus.
 *
 * @property int $id
 * @property string $label
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationRoleStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationRoleStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationRoleStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationRoleStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationRoleStatus whereLabel($value)
 * @mixin \Eloquent
 */
class OrganizationRoleStatus extends Model
{
    public $timestamps = false;
}
