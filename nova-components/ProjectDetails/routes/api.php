<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Project;
use App\Asanahelper;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. You're free to add
| as many additional routes to this file as your tool may require.
|
*/

Route::get('/loadCommunity/{id}', function (Request $request, $id) {
    $project = Project::find($id);

    $asana = new Asanahelper();
    $response = json_decode($asana->accessToken('1151360720602219'));

    $context = stream_context_create(array(
        'http' => array(
            'Accept' => 'application/json',
            'header'  => "Authorization: bearer " . $response->access_token
        )
    ));
    $asanaProj = file_get_contents('https://app.asana.com/api/1.0/projects/'.$project->project_id, false, $context);
    return ['project' => json_decode($asanaProj), 'projLocal' => $project];

});
Route::post('/deleteCommunity', function (Request $request) {

    $project = Project::find($request->projectId);
    if(!$project){
        return 'Something Wrong';
    }else{
        $projectId = $project->project_id;
        $project->delete();
    }
    
    $asana = new Asanahelper();
    $response = json_decode($asana->accessToken('1151360720602219'));
    
    $context = stream_context_create(array(
        'http' => array(
            'Accept' => 'application/json',
            'header'  => "Authorization: bearer " . $response->access_token,
            'method' => 'DELETE'
        )
    ));
    $socialprofiles = file_get_contents('https://app.asana.com/api/1.0/projects/'.$projectId, false, $context);
    return $socialprofiles;

});
