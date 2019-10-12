<?php

use App\Models\ActivityLog;
use App\Models\CMCommunity;
use App\Modification;
use Illuminate\Http\Request;
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

 Route::post('/community', function (Request $request) {
     return CMCommunity::where('COMMUNITYID', $request->get('communityId'))->with(['crmForeclosureSale', 'housingData', 'communityLogo',
         'configuration',
         'salesConfiguration', 'miscConfiguration', 'rentalVacantSalesStatus', 'state', 'contracts', 'relationshipManagers', 'brandingConfiguration', 'salesCycles', ])->get();
 });

Route::post('/foreclosures', function (Request $request) {
    return CMCommunity::where('COMMUNITYID', $request->get('communityId'))->with(['foreclosureStats'])->first()->foreclosureStats->where('ISMOSTCURRENT', 1)->first() ? CMCommunity::where('COMMUNITYID', $request->get('communityId'))->with(['foreclosureStats'])->first()->foreclosureStats->where('ISMOSTCURRENT', 1)->first()->FORECLOSURESACTIVE : 0;
});

Route::post('/latestActivity', function (Request $request) {
    return ActivityLog::where('subject_id', $request->get('communityId'))->with(['user'])->latest()->first();
});

Route::post('/pendingChanges', function (Request $request) {
    return Modification::where([
        ['community_id', '=', $request->get('communityId')],
        ['active', '=', '1'],
    ])->count();
});
