<?php

use App\Models\State;
use App\Models\CMCommunity;
use App\Models\SalesCycle;
use App\Models\SavedFilter;
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
Route::post('/saveFilter', function (Request $request, SavedFilter $savedFilter) {
    $savedFilter->user_id = Auth::id();
    $savedFilter->resource_id = $request->get('resourceId');
    $savedFilter->title = $request->get('title');
    $savedFilter->filter = $request->get('filter');
    $savedFilter->save();

    return response(200);
});

Route::get('/savedFilters', function () {
    return SavedFilter::select(['id', 'title', 'filter'])->where('user_id', Auth::id())->get()->sortBy('id')->map(function ($item) {
        return [
            'id' => $item['id'],
            'label' => $item['title'],
            'filter' => $item['filter'],
        ];
    });
});

Route::get('/states', function () {
    return State::select(['name', 'code'])->get()->sortBy('name')->map(function ($item) {
        return [
            'id' => $item['code'],
            'label' => $item['name'],
        ];
    });
});

Route::post('/counties', function (Request $request) {
    return CMCommunity::where('STATE',
        $request->get('communityState'))->select('COUNTY')->groupBy('COUNTY')->get()->map(function ($item) {
            return [
            'id' => $item['COUNTY'],
            'label' => $item['COUNTY'],
        ];
        })->forget(0);
});

Route::post('/salesCycle', function (Request $request) {
    $cycles = SalesCycle::groupBy('community_id')->select('community_id', DB::raw('count(*) as total'))->get();
    $cmIds = $cycles->pluck('community_id')->toArray();
    return CMCommunity::wherein('COMMUNITYID', $cmIds)->select('COMMUNITYID','FRIENDLYNAME')->get()->map(function ($item) {
        return [
        'id' => $item['COMMUNITYID'],
        'label' => $item['FRIENDLYNAME'],
    ];
    });
});
