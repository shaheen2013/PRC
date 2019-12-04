<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/connect/oauth/asana/secure/{id}', 'AsanaController@index')->name('oauthAsana');


Route::get('/accessToken/{data}', function($data){
    Session::put('createProjData', $data);
    return redirect("https://app.asana.com/-/oauth_authorize?client_id=".env('ASANA_CLIENT_ID')."&redirect_uri=".env('ASANA_REDIRECT_URL')."&response_type=code&state=thisIsARandomString&scope=default");
});
