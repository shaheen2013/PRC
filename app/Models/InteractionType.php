<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InteractionType.
 *
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Interaction[] $interactions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InteractionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InteractionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InteractionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InteractionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InteractionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InteractionType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InteractionType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InteractionType extends Model
{
    public function interactions()
    {
        return $this->hasMany(\App\Models\Interaction::class);
    }
}
