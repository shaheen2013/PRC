<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::post('/count', function (Request $request) {
    $query = DB::connection('mysql_dev')->table('osusr_mlv_community');
    $foreclosureQuery = DB::connection('mysql_dev')->table('osusr_mlv_community');

    $rentalFilters = collect($request->get('filters'))->get('rental');
    $vacantFilters = collect($request->get('filters'))->get('vacant');
    $foreclosureFilters = collect($request->get('filters'))->get('foreclosure');
    $sizeFilter = collect($request->get('filters'))->get('size');
    $rmFilter = collect($request->get('filters'))->get('rm');
    $stateFilters = collect($request->get('filters'))->get('state');
    $countyFilters = collect($request->get('filters'))->get('county');
    $bulkIdFilter = collect($request->get('filters'))->get('bulkId');

    $query->leftJoin('cm_community_quartiles as u', 'osusr_mlv_community.COMMUNITYID', '=', 'u.community_id');
    $query->leftJoin('cm_rental_vacant_sales_statuses as s', 'osusr_mlv_community.COMMUNITYID', '=', 's.community_id');
    $query->leftJoin('osusr_tvl_crm as c', 'osusr_mlv_community.COMMUNITYID', '=', 'c.COMMUNITYID');
    //  $query->leftJoin('osusr_tvl_crm_rm as r', "osusr_mlv_community.COMMUNITYID", '=', 'r.COMMUNITYID');

    //  $foreclosureQuery->leftJoin('osusr_tvl_crm_rm as r', "osusr_mlv_community.COMMUNITYID", '=', 'r.COMMUNITYID');
    $foreclosureQuery->leftJoin('osusr_tvl_crm as c', 'osusr_mlv_community.COMMUNITYID', '=', 'c.COMMUNITYID');
    $foreclosureQuery->leftJoin('cm_community_quartiles as u', 'osusr_mlv_community.COMMUNITYID', '=', 'u.community_id');
    $foreclosureQuery->leftJoin('cm_rental_vacant_sales_statuses as s', 'osusr_mlv_community.COMMUNITYID', '=', 's.community_id');
    $foreclosureQuery->leftJoin('OSUSR_tvl_RTStatsSummaryHistory as f', 'osusr_mlv_community.COMMUNITYID', '=', 'f.COMMCOMMUNITYID');

    $rentalFilterUsed = false;
    $vacantFilterUsed = false;
    $foreclosureFilterUsed = false;
    $sizeFilterUsed = false;

    if ($request->get('filtersAreApplied')) {
        $query->where(function ($query) use ($foreclosureQuery, $rentalFilterUsed, $rentalFilters) {
            if ($rentalFilters === true) {
                if ($rentalFilterUsed) {
                    $query->orWhere('s.rental_partner_status', '=', 1);
                    $foreclosureQuery->orWhere('s.rental_partner_status', '=', 1);
                } else {
                    $query->where('s.rental_partner_status', '=', 1);
                    $foreclosureQuery->where('s.rental_partner_status', '=', 1);
                    $rentalFilterUsed = true;
                }
            }
        });
        $query->where(function ($query) use ($foreclosureQuery, $vacantFilterUsed, $vacantFilters) {
            if ($vacantFilters === true) {
                if ($vacantFilterUsed) {
                    $query->orWhere('s.vacant_partner_status', '=', 1);
                    $foreclosureQuery->orWhere('s.vacant_partner_status', '=', 1);
                } else {
                    $query->where('s.vacant_partner_status', '=', 1);
                    $foreclosureQuery->where('s.vacant_partner_status', '=', 1);
                    $vacantFilterUsed = true;
                }
            }
        });
        $query->where(function ($query) use ($foreclosureQuery, $foreclosureFilterUsed, $foreclosureFilters) {
            if ($foreclosureFilters === true) {
                if ($foreclosureFilterUsed) {
                    $query->orWhere('s.foreclosure_partner_status', '=', 1);
                    $foreclosureQuery->orWhere('s.foreclosure_partner_status', '=', 1);
                } else {
                    $query->where('s.foreclosure_partner_status', '=', 1);
                    $foreclosureQuery->where('s.foreclosure_partner_status', '=', 1);
                    $foreclosureFilterUsed = true;
                }
            }
        });
        $query->where(function ($query) use ($foreclosureQuery, $sizeFilterUsed, $sizeFilter) {
            foreach ($sizeFilter as $key => $value) {
                if ($value === true) {
                    if ($sizeFilterUsed) {
                        $query->orWhere('u.quartile', '=', $key);
                        $foreclosureQuery->orWhere('u.quartile', '=', $key);
                    } else {
                        $query->where('u.quartile', '=', $key);
                        $foreclosureQuery->where('u.quartile', '=', $key);
                        $sizeFilterUsed = true;
                    }
                }
            }
        });
        if ($stateFilters) {
            $query->where('STATE', '=', $stateFilters);
            $foreclosureQuery->where('STATE', '=', $stateFilters);
        }
        if ($countyFilters) {
            $query->where('COUNTY', '=', $countyFilters);
            $foreclosureQuery->where('COUNTY', '=', $countyFilters);
        }
        if ($bulkIdFilter) {
            $query->whereIn('osusr_mlv_community.COMMUNITYID', array_filter(preg_split('/\r\n|\r|\n/', $bulkIdFilter)));
            $foreclosureQuery->whereIn('osusr_mlv_community.COMMUNITYID', array_filter(preg_split('/\r\n|\r|\n/', $bulkIdFilter)));
        }

//        if  ($rmFilter !== "") {
//            $query->where('r.ORGANIZATIONID', '=', $rmFilter);
//            $foreclosureQuery->where('r.ORGANIZATIONID', '=', $rmFilter);
//        }
        return response([
            'communities'  => $query->count(),
            'households'    => (int) $query->sum('u.housing_units'),
            'rental'       => (int) $query->sum('s.rental_partner_status', '=', 1),
            'vacant'       => (int) $query->sum('s.vacant_partner_status', '=', 1),
            'foreclosure'  => (int) $foreclosureQuery->sum('s.foreclosure_partner_status', '=', 1),
        ]);
    } else {
        return Cache::remember('community-list-dashboard-no-filter', 10080, function () use ($query, $foreclosureQuery) {
            return response([
                'communities'  => $query->count(),
                'households'    => (int) $query->sum('u.housing_units'),
                'rental'       => (int) $query->sum('s.rental_partner_status', '=', 1),
                'vacant'       => (int) $query->sum('s.vacant_partner_status', '=', 1),
                'foreclosure'  => (int) $foreclosureQuery->sum('s.foreclosure_partner_status', '=', 1),
            ]);
        });
    }
});

