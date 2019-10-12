<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\OrganizationType.
 *
 * @method static create(array $array)
 * @property int $id
 * @property string $label
 * @property int $order
 * @property string $abbreviation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationType whereAbbreviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrganizationType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrganizationType extends Model
{
    //
}
