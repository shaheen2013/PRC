<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CommunityQuartile.
 *
 * @property int $id
 * @property int $community_id
 * @property int $quartile
 * @property int $housing_units
 * @property int|null $est_long_term_rental
 * @property int|null $est_vacant_total
 * @property int|null $est_vacant_rental
 * @property int|null $est_vacant_for_sale
 * @property int|null $est_vacant_seasonal
 * @property int|null $est_vacant_long_term
 * @property-read \App\Models\CMCommunity $community
 * @property-read mixed $quartile_label
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile whereCommunityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile whereEstLongTermRental($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile whereEstVacantForSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile whereEstVacantLongTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile whereEstVacantRental($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile whereEstVacantSeasonal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile whereEstVacantTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile whereHousingUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityQuartile whereQuartile($value)
 * @mixin \Eloquent
 */
class CommunityQuartile extends Model
{
    protected $primaryKey = 'community_id';

    protected $connection = 'mysql_dev';

    protected $table = 'cm_community_quartiles';

    public $timestamps = false;

    public function community()
    {
        return $this->hasOne(\App\Models\CMCommunity::class, 'COMMUNITYID', 'community_id');
    }

    public function getQuartileLabelAttribute()
    {
        switch ($this->quartile) {
            case 0:
                return 'X-Small';
            case 1:
                return 'Small';
            case 2:
                return 'Medium';
            case 3:
                return 'Large';
            case 4:
                return 'X-Large';
            default:
                return '';
        }
    }
}
