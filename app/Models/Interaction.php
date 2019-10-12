<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Interaction.
 *
 * @property int $id
 * @property int $contact_id
 * @property int $type_id
 * @property string $subject
 * @property string $body
 * @property \Illuminate\Support\Carbon $date
 * @property string|null $phoneNumber
 * @property string|null $location
 * @property string|null $email
 * @property int $user_id
 * @property int $private
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contact $contact
 * @property-read \App\Models\InteractionType $interactionType
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction wherePrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Interaction whereUserId($value)
 * @mixin \Eloquent
 */
class Interaction extends Model
{
    use LogsActivity;

    protected $connection = 'mysql_dev';

    protected $table = 'cm_interactions';

    protected $guarded = [];

    protected $dates = [
        'date',
    ];

    protected static $logUnguarded = true;

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($interaction) {
            $interaction->contacts = substr($interaction->contacts, 1, -1);
        });
        static::saved(function (self $interaction) {
            $contacts = explode(',', $interaction->contacts);
            foreach ($contacts as $contactId) {
                $interaction->contacts()->attach($contactId);
            }
        });
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_id = $this->community->COMMUNITYID;
    }

    public function community()
    {
        return $this->belongsTo(\App\Models\CMCommunity::class, 'community_id', 'COMMUNITYID');
    }

    public function interactionType()
    {
        return $this->belongsTo(\App\Models\InteractionType::class, 'type_id', 'id');
    }

    public function contacts()
    {
        return $this->belongsToMany(\App\Models\Contact::class, 'cm_contact_interaction', 'interaction_id', 'contact_id')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
