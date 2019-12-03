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


Route::get('/accessToken', function(){https://app.asana.com/-/oauth_authorize?client_id=1151360720602219&redirect_uri=https://nova.local&response_type=code&scope=default
    return redirect("https://app.asana.com/-/oauth_authorize?client_id=".env('ASANA_CLIENT_ID')."&redirect_uri=".env('ASANA_REDIRECT_URL')."&response_type=code&scope=default");
});
