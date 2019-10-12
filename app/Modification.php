<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Approval\Models\Modification as ModelModification;

class Modification extends ModelModification
{
    public $incrementing = true;

    protected $connection = 'mysql';

    protected $dates = [
        'created_at', 'updated_at',
    ];

    /**
     * Override the default boot method to register some extra stuff for every child model.
     */
    protected static function boot()
    {
        static::updated(function ($model) {
            return $model->beingUpdated($model);
        });
        static::creating(function ($model) {
            return $model->beingCreated($model);
        });
        parent::boot();
    }

    /**
     * Stub 'creating' event handler.
     */
    public function beingUpdated($model)
    {
        //  dd($model);
        if ($model->modifications === []) {
            return false;
        } else {
            $modification = self::with(['modifiable'])->find($model->id);

            if ($modification->modifiable_type === \App\Models\CRMCommunitySale::class || $modification->modifiable_type === \App\Models\CommunitySalesConfiguration::class) {
                $modification->community_id = $modification->modifiable_id;
            } elseif ($modification->modifiable_type === \App\Models\SalesCycle::class || $modification->modifiable_type === \App\Models\Contract::class || $modification->modifiable_type === \App\Models\RentalVacantSalesStatus::class || $modification->modifiable_type === \App\Models\CommunityConfiguration::class || $modification->modifiable_type === \App\Models\CommunityMiscConfiguration::class) {
                if (Arr::has($model->modifications, 'community_id')) {
                    $modification->community_id = $modification->modifications['community_id']['modified'];
                    $modArray = $modification->modifications;
                    $modification->modifications = $modArray;
                } else {
                }
            } elseif (! $modification->modifiable_type) {
            }
            //else {
            //        dd($modification);
//                if(Arr::has($model->modifications, 'community_id')) {
//                    $modification->community_id = $modification->modifications['community_id']['modified'];
//                } else {
//                    dd($modification);
//                }
            //}

            $modification->save();

            return true;
        }
    }

    public function beingCreated($model)
    {
        if (! Arr::has($model->modifications, 'community_id')) {
            return $model->modifications ? true : false;
        }
        if ($model && Arr::has($model->modifications, 'community_id')) {
            $modification = $model->modifications;
            $communityId = $modification['community_id'];
            unset($modification['community_id']);
            foreach ($modification as $key => $value) {
                if ($modification[$key]['original'] === $modification[$key]['modified']) {
                    unset($modification[$key]);
                }
            }
            if (count($modification) == 0) {
                return false;
            }

            $communityIdArray = ['community_id' => $communityId];
            $model->modifications = array_merge($communityIdArray, $modification);
        }

        return $model->modifications ? true : false;
    }
}
