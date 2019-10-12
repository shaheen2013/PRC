<?php

use App\Models\CMOtr;
use App\Models\CMCommunity;
use Illuminate\Http\Request;
use App\Models\CMRtStatsSummaryHistory;
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

Route::get('/rental', function (Request $request) {
    return Cache::remember('rental', 10080, function () {
        $communitiesWithoutStatus = CMCommunity::doesntHave('rentalVacantSalesStatus')->get();
        $rentalNoActivityCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('rental_status', '=', 1);
        })->get()->merge($communitiesWithoutStatus);
        $rentalGenerateCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->whereIn('rental_status', [7, 13]);
        })->get();
        $rentalGuideCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('rental_status', '=', 11);
        })->get();
        $rentalProposeCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('rental_status', '=', 12);
        })->get();
        $rentalOnboardCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('rental_status', '=', 6);
        })->get();
        $rentalEnhanceCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->whereIn('rental_status', [5, 14])->orWhere('rental_status');
        })->get();

        return response([
            'cms' => [
                'noActivity' => $rentalNoActivityCommunities->count(),
                'generate' => $rentalGenerateCommunities->count(),
                'guide' => $rentalGuideCommunities->count(),
                'propose' => $rentalProposeCommunities->count(),
                'onboard' => $rentalOnboardCommunities->count(),
                'enhance' => $rentalEnhanceCommunities->count(),
            ],
            'otrs' => [
                'noActivity' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalNoActivityCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_long_term_rental')),
                'generate' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalGenerateCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_long_term_rental')),
                'guide' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalGuideCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_long_term_rental')),
                'propose' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalProposeCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_long_term_rental')),
                'onboard' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalOnboardCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_long_term_rental')),
                'enhance' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalEnhanceCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_long_term_rental')),
            ],
            'households' => [
                'noActivity' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalNoActivityCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'generate' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalGenerateCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'guide' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalGuideCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'propose' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalProposeCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'onboard' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalOnboardCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'enhance' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $rentalEnhanceCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
            ],
        ]);
    });
});

Route::get('/vacant', function (Request $request) {
    return Cache::remember('vacant', 10080, function () {
        $communitiesWithoutStatus = CMCommunity::doesntHave('rentalVacantSalesStatus')->get();
        $vacantNoActivityCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('vacant_status', '=', 1);
        })->get()->merge($communitiesWithoutStatus);
        $vacantGenerateCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->whereIn('vacant_status', [7, 13]);
        })->get();
        $vacantGuideCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('vacant_status', '=', 11);
        })->get();
        $vacantProposeCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('vacant_status', '=', 12);
        })->get();
        $vacantOnboardCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->where('vacant_status', '=', 6);
        })->get();
        $vacantEnhanceCommunities = CMCommunity::whereHas('rentalVacantSalesStatus', function ($q) {
            $q->whereIn('vacant_status', [5, 14]);
        })->get();

        return response([
            'cms' => [
                'noActivity' => $vacantNoActivityCommunities->count(),
                'generate' => $vacantGenerateCommunities->count(),
                'guide' => $vacantGuideCommunities->count(),
                'propose' => $vacantProposeCommunities->count(),
                'onboard' => $vacantOnboardCommunities->count(),
                'enhance' => $vacantEnhanceCommunities->count(),
            ],
            'otrs' => [
                'noActivity' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantNoActivityCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_vacant_total')),
                'generate' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantGenerateCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_vacant_total')),
                'guide' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantGuideCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_vacant_total')),
                'propose' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantProposeCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_vacant_total')),
                'onboard' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantOnboardCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_vacant_total')),
                'enhance' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantEnhanceCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('est_vacant_total')),
            ],
            'households' => [
                'noActivity' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantNoActivityCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'generate' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantGenerateCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'guide' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantGuideCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'propose' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantProposeCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'onboard' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantOnboardCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'enhance' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $vacantEnhanceCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
            ],
        ]);
    });
});

Route::get('/foreclosure', function (Request $request) {
    return Cache::remember('foreclosure', 10080, function () {
        $foreclosureNoActivityCommunities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->where('id', '=', 1);
        })->get();

        $foreclosureGenerateCommunities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->whereIn('id', [7.13]);
        })->get();

        $foreclosureGuideCommunities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->where('id', '=', 11);
        })->get();

        $foreclosureProposeCommunities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->where('id', '=', 12);
        })->get();

        $foreclosureOnboardCommunities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->where('id', '=', 6);
        })->get();

        $foreclosureEnhanceCommunities = CMCommunity::whereHas('crmForeclosureSale.salesStatus', function ($q) {
            $q->whereIn('id', [5, 14]);
        })->get();

        return response([
            'cms' => [
                'noActivity' => $foreclosureNoActivityCommunities->count(),
                'generate' => $foreclosureGenerateCommunities->count(),
                'guide' => $foreclosureGuideCommunities->count(),
                'propose' => $foreclosureProposeCommunities->count(),
                'onboard' => $foreclosureOnboardCommunities->count(),
                'enhance' => $foreclosureEnhanceCommunities->count(),
            ],
            'otrs' => [
                'noActivity' => intval(CMRtStatsSummaryHistory::whereIn('COMMCOMMUNITYID',
                    $foreclosureNoActivityCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->where('ISMOSTCURRENT', '=', 1)->sum('FORECLOSURESACTIVE')),
                'generate' => intval(CMRtStatsSummaryHistory::whereIn('COMMCOMMUNITYID',
                    $foreclosureGenerateCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->where('ISMOSTCURRENT', '=', 1)->sum('FORECLOSURESACTIVE')),
                'guide' => intval(CMRtStatsSummaryHistory::whereIn('COMMCOMMUNITYID',
                    $foreclosureGuideCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->where('ISMOSTCURRENT', '=', 1)->sum('FORECLOSURESACTIVE')),
                'propose' => intval(CMRtStatsSummaryHistory::whereIn('COMMCOMMUNITYID',
                    $foreclosureProposeCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->where('ISMOSTCURRENT', '=', 1)->sum('FORECLOSURESACTIVE')),
                'onboard' => intval(CMRtStatsSummaryHistory::whereIn('COMMCOMMUNITYID',
                    $foreclosureOnboardCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->where('ISMOSTCURRENT', '=', 1)->sum('FORECLOSURESACTIVE')),
                'enhance' => intval(CMOtr::whereIn('COMMUNITYID',
                    $foreclosureEnhanceCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->where('CLOSEDATE', '=', '1900-01-01 00:00:00')
                    ->orWhere('CLOSEDATE', '>', \Carbon\Carbon::now())
                    ->count()),
            ],
            'households' => [
                'noActivity' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $foreclosureNoActivityCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'generate' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $foreclosureGenerateCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'guide' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $foreclosureGuideCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'propose' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $foreclosureProposeCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'onboard' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $foreclosureOnboardCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
                'enhance' => intval(\App\Models\CommunityQuartile::whereIn('community_id',
                    $foreclosureEnhanceCommunities->map(function ($item, $key) {
                        return $item->COMMUNITYID;
                    }))->sum('housing_units')),
            ],
        ]);
    });
});

