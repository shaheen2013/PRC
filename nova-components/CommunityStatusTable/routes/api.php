<?php

use App\CMOtr;
use App\Models\CMCommunity;
use Illuminate\Http\Request;
use App\CMRtStatsSummaryHistory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Card API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

Route::get('/rentalNoActivity', function (Request $request) {
    return Cache::remember('rentalNoActivity', 10080, function () {
        $communities2 = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('rental_status', '=', 1);
        })->get();
        $communities1 = CMCommunity::doesntHave('rentalVacantSalesStatus')->get();
        $merged = $communities1->merge($communities2);

        return response([
            'cms' => $merged->count(),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $merged->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_long_term_rental'),
        ]);
    });
});

Route::get('/rentalGenerate', function (Request $request) {
    return Cache::remember('rentalGenerate', 10080, function () {
        $communities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('rental_status', '=', 7)->orWhere('rental_status', '=', 13);
        })->get();

        return response([
            'cms' => ($communities->count()),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_long_term_rental'),
        ]);
    });
});

Route::get('/rentalGuide', function (Request $request) {
    return Cache::remember('rentalGuide', 10080, function () {
        $communities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('rental_status', '=', 11);
        })->get();

        return response([
            'cms' => ($communities->count()),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_long_term_rental'),
        ]);
    });
});

Route::get('/rentalPropose', function (Request $request) {
    return Cache::remember('rentalPropose', 10080, function () {
        $communities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('rental_status', '=', 12);
        })->get();

        return response([
            'cms' => ($communities->count()),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_long_term_rental'),
        ]);
    });
});

Route::get('/rentalOnboard', function (Request $request) {
    return Cache::remember('rentalOnboard', 10080, function () {
        $communities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('rental_status', '=', 6);
        })->get();

        return response([
            'cms' => ($communities->count()),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_long_term_rental'),
        ]);
    });
});

Route::get('/rentalEnhance', function (Request $request) {
    return Cache::remember('rentalEnhance', 10080, function () {
        $communities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('rental_status', '=', 5);
        })->get();

        return response([
            'cms' => ($communities->count()),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_long_term_rental'),
        ]);
    });
});

Route::get('/vacantNoActivity', function (Request $request) {
    return Cache::remember('vacantNoActivity', 10080, function () {
        $communities2 = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('vacant_status', '=', 1);
        })->get();
        $communities1 = CMCommunity::doesntHave('rentalVacantSalesStatus')->get();
        $merged = $communities1->merge($communities2);

        return response([
            'cms' => $merged->count(),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $merged->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_vacant_total'),
        ]);
    });
});

Route::get('/vacantGenerate', function (Request $request) {
    return Cache::remember('vacantGenerate', 10080, function () {
        $communities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('vacant_status', '=', 7)->orWhere('vacant_status', '=', 13);
        })->get();

        return response([
            'cms' => ($communities->count()),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_vacant_total'),
        ]);
    });
});

Route::get('/vacantGuide', function (Request $request) {
    return Cache::remember('vacantGuide', 10080, function () {
        $communities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('vacant_status', '=', 11);
        })->get();

        return response([
            'cms' => ($communities->count()),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_vacant_total'),
        ]);
    });
});

Route::get('/vacantPropose', function (Request $request) {
    return Cache::remember('vacantPropose', 10080, function () {
        $communities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('vacant_status', '=', 12);
        })->get();

        return response([
            'cms' => ($communities->count()),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_vacant_total'),
        ]);
    });
});

Route::get('/vacantOnboard', function (Request $request) {
    return Cache::remember('vacantOnboard', 10080, function () {
        $communities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('vacant_status', '=', 6);
        })->get();

        return response([
            'cms' => ($communities->count()),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_vacant_total'),
        ]);
    });
});

Route::get('/vacantEnhance', function (Request $request) {
    return Cache::remember('vacantEnhance', 10080, function () {
        $communities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('vacant_status', '=', 5);
        })->get();

        return response([
            'cms' => ($communities->count()),
            'otrs' => \App\Models\CommunityQuartile::whereIn('community_id', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->sum('est_vacant_total'),
        ]);
    });
});

Route::get('/foreclosureNoActivity', function (Request $request) {
    return Cache::remember('foreclosureNoActivity', 10080, function () {
        $communities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->where('id', '=', 1);
        })->get();

        return response([
            'cms' => $communities->count(),
            'otrs' => CMRtStatsSummaryHistory::whereIn('COMMCOMMUNITYID', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->where('ISMOSTCURRENT', '=', 1)->sum('FORECLOSURESACTIVE'),
        ]);
    });
});

Route::get('/foreclosureGenerate', function (Request $request) {
    return Cache::remember('foreclosureGenerate', 10080, function () {
        $communities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->where('id', '=', 7)->orWhere('id', '=', 13);
        })->get();

        return response([
            'cms' => $communities->count(),
            'otrs' => CMRtStatsSummaryHistory::whereIn('COMMCOMMUNITYID', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->where('ISMOSTCURRENT', '=', 1)->sum('FORECLOSURESACTIVE'),
        ]);
    });
});

Route::get('/foreclosureGuide', function (Request $request) {
    return Cache::remember('foreclosureGuide', 10080, function () {
        $communities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->where('id', '=', 11);
        })->get();

        return response([
            'cms' => $communities->count(),
            'otrs' => CMRtStatsSummaryHistory::whereIn('COMMCOMMUNITYID', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->where('ISMOSTCURRENT', '=', 1)->sum('FORECLOSURESACTIVE'),
        ]);
    });
});

Route::get('/foreclosurePropose', function (Request $request) {
    return Cache::remember('foreclosurePropose', 10080, function () {
        $communities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->where('id', '=', 12);
        })->get();

        return response([
            'cms' => $communities->count(),
            'otrs' => CMRtStatsSummaryHistory::whereIn('COMMCOMMUNITYID', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->where('ISMOSTCURRENT', '=', 1)->sum('FORECLOSURESACTIVE'),
        ]);
    });
});

Route::get('/foreclosureOnboard', function (Request $request) {
    return Cache::remember('foreclosureOnboard', 10080, function () {
        $communities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->where('id', '=', 6);
        })->get();

        return response([
            'cms' => $communities->count(),
            'otrs' => CMRtStatsSummaryHistory::whereIn('COMMCOMMUNITYID', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->where('ISMOSTCURRENT', '=', 1)->sum('FORECLOSURESACTIVE'),
        ]);
    });
});

Route::get('/foreclosureEnhance', function (Request $request) {
    return Cache::remember('foreclosureEnhance', 10080, function () {
        $communities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->where('id', '=', 5);
        })->get();

        return response([
            'cms' => $communities->count(),
            'otrs' => CMOtr::whereIn('COMMUNITYID', $communities->map(function ($item, $key) {
                return $item->COMMUNITYID;
            }))->where('CLOSEDATE', '=', '1900-01-01 00:00:00')
                ->orWhere('CLOSEDATE', '>', \Carbon\Carbon::now())
                ->count(),
        ]);
    });
});
