<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CommunityStatus.
 *
 * @property int $id
 * @property string $label
 * @property string $external_label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityStatus whereExternalLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityStatus whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CommunityStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CommunityStatus extends Model
{
    protected $guarded = [];

    protected $table = 'community_statuses';

    /**
     * @return array
     */
    public function allOptions()
    {
        return [
            1 => 'Not Reviewd',
            3 => 'Approved',
            4 => 'Updated Saved',
            5 => 'Pending Approval',
            6 => 'No Ordinance',
            7 => 'Update Requested',
        ];
    }
}
