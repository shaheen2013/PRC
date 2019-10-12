<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedFilter extends Model
{
    /**
     * App\SavedFilter.
     *
     * @property string $code
     * @property string $name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\SavedFilter newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\SavedFilter newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\SavedFilter query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\SavedFilter whereUpdatedAt($value)
     * @mixin \Eloquent
     */
    protected $connection = 'mysql_dev';

    protected $table = 'cm_saved_filters';

    protected $guarded = [];
}
