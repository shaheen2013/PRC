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
    $SalesCycle = collect($request->get('filters'))->get('SalesCycle');
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
        $query->where(function ($query) use ($foreclosureQuery, $rentalFilterUsed, $rentalFilters, $vacantFilterUsed, $vacantFilters, $foreclosureFilterUsed, $foreclosureFilters) {
            if ($rentalFilters['value'] === true) {
                if ($rentalFilterUsed) {
                    $query->orWhere('s.rental_partner_status', '=', 1);
                    $foreclosureQuery->orWhere('s.rental_partner_status', '=', 1);
                } else {
                    $query->orWhere('s.rental_partner_status', '=', 1);
                    $foreclosureQuery->orWhere('s.rental_partner_status', '=', 1);
                    $rentalFilterUsed = true;
                }
            }

            if ($vacantFilters['value'] === true) {
                if ($vacantFilterUsed) {
                    $query->orWhere('s.vacant_partner_status', '=', 1);
                    $foreclosureQuery->orWhere('s.vacant_partner_status', '=', 1);
                } else {
                    $query->orWhere('s.vacant_partner_status', '=', 1);
                    $foreclosureQuery->orWhere('s.vacant_partner_status', '=', 1);
                    $vacantFilterUsed = true;
                }
            }

            if ($foreclosureFilters['value'] === true) {
                if ($foreclosureFilterUsed) {
                    $query->orWhere('s.foreclosure_partner_status', '=', 1);
                    $foreclosureQuery->orWhere('s.foreclosure_partner_status', '=', 1);
                } else {
                    $query->orWhere('s.foreclosure_partner_status', '=', 1);
                    $foreclosureQuery->orWhere('s.foreclosure_partner_status', '=', 1);
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
        if($stateFilters){
            if ($stateFilters['value']) {
                $query->orwhere('STATE', '=', $stateFilters['value']);
                $foreclosureQuery->orwhere('STATE', '=', $stateFilters['value']);
            }
        }
        if($SalesCycle){
            $query->leftJoin('cm_sales_cycles as y', 'osusr_mlv_community.COMMUNITYID', '=', 'y.community_id');
            $foreclosureQuery->leftJoin('cm_sales_cycles as y', 'osusr_mlv_community.COMMUNITYID', '=', 'y.community_id');

            if ($SalesCycle[11] == true) {
                $query->where('y.sales_stage', '=', 11);
                $foreclosureQuery->where('y.sales_stage', '=', 11);
            }
            if ($SalesCycle[12] == true) {
                $query->where('y.sales_stage', '=', 12);
                $foreclosureQuery->where('y.sales_stage', '=', 12);
            }
            if ($SalesCycle[13] == true) {
                $query->where('y.sales_stage', '=', 13);
                $foreclosureQuery->where('y.sales_stage', '=', 13);
            }
            if ($SalesCycle[6] == true) {
                $query->where('y.sales_stage', '=', 6);
                $foreclosureQuery->where('y.sales_stage', '=', 6);
            }
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
            'rental'       => (int) $query->sum('u.est_long_term_rental'),
            'vacant'       => (int) $query->sum('u.est_vacant_total'),
            'foreclosure'  => (int) $foreclosureQuery->where('f.ISMOSTCURRENT', '=', 1)->sum('f.FORECLOSURESACTIVE'),
        ]);
    } else {
        return Cache::remember('community-list-dashboard-no-filter', 10080, function () use ($query, $foreclosureQuery) {
            return response([
                'communities'  => $query->count(),
                'households'    => (int) $query->sum('u.housing_units'),
                'rental'       => (int) $query->sum('u.est_long_term_rental'),
                'vacant'       => (int) $query->sum('u.est_vacant_total'),
                'foreclosure'  => (int) $foreclosureQuery->where('f.ISMOSTCURRENT', '=', 1)->sum('f.FORECLOSURESACTIVE'),
            ]);
        });
    }
});