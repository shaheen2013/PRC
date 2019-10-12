<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\State.
 *
 * @property string $code
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\State query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\State whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\State whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\State whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\State whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class State extends Model
{
    use LogsActivity;

    protected $casts = [
        'excluded' => 'boolean',
    ];

    public $incrementing = false;

    protected $connection = 'mysql_dev';

    protected $table = 'cm_state_config';

    protected $guarded = [];

    protected static $logUnguarded = true;

    public function communities()
    {
        return $this->hasMany(\App\Models\CMCommunity::class, 'STATE', 'code');
    }

    public function countyList()
    {
        $keyed = CMCommunity::where('STATE', $this->code)->get()->pluck('COUNTY')->unique();

        return $keyed->values()->all();
    }
}
