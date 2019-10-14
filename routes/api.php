<?php

use App\Models\Contact;
use App\Models\CMCommunity;
use App\Models\ContactRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'asana'], function () {
    Route::group(['prefix' => 'project',], function () {
        Route::get('/', 'ProjectController@index');
        Route::get('/create', 'ProjectController@create');
        Route::post('/store', 'ProjectController@store');
        Route::put('/update/{id}', function () { dd('Project Edit'); });
        Route::delete('/destroy/{id}', function () { dd('Project Remove'); });
    });
    Route::group(['prefix' => 'task',], function () {
        Route::get('/', 'TaskController@index');
        Route::get('/create', 'TaskController@create');
        Route::post('/store', 'TaskController@store');
        Route::put('/update/{id}', function () { dd('Project Edit'); });
        Route::delete('/destroy/{id}', function () { dd('Project Remove'); });
    });
});

Route::get('/community/{community}/remittance/contacts', function ($community_id) {
    $community = CMCommunity::with(['salesConfiguration'])->find($community_id);
    if ($community) {
        $contacts = [];
        foreach (ContactRole::whereIn('contact_id', CMCommunity::find($community_id)->contacts()->pluck('id'))->where('role_id', 1)->get() as $contactRole) {
            array_push($contacts, Contact::find($contactRole->contact_id)->email);
        }

        return response()->json([
            'requiresEmail' => count($contacts) > 0,
            'contacts' => $contacts,
        ]);
    } else {
        return response('Community Not Found', 500);
    }
});

Route::middleware('auth:api')->get('/community/{community}/contacts', function ($community_id) {
    $company = \App\Models\CMCommunity::find($community_id);
    return $company->contacts->map(function ($contact) {
        return ['value' => $contact->id, 'display' => $contact->first_name.' '.$contact->last_name];
    });
});

Route::middleware('auth:api')->get('/community-list/{search}', function (Request $request, $search) {
    return response(\App\Models\CMCommunity::where('FRIENDLYNAME', 'like', '%'.$search.'%')->take(20)->get()->toArray());
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


