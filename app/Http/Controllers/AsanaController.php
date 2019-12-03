<?php

namespace App\Http\Controllers;

use Asana;
use AsanaAuth;
use Illuminate\Http\Request;

class AsanaController extends Controller
{
    private $asanaAuth;
    protected $asana;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // See class comments and Asana API for extra info
        $this->asanaAuth = new AsanaAuth(env('ASANA_CLIENT_ID'), env('ASANA_CLIENT_SECRET'), env('ASANA_REDIRECT_URL'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!isset($_GET['code'])) {
            // We don't have the code so we need to authorize our app.
            // Get the url.
            $url = $this->asanaAuth->getAuthorizeUrl();
            // Redirect the user to asana authorization url.
            header('Location:' . $url);
            // Now the user will authorize the app and this page will load again having the ?code parameter that we can use.
        } else {
            // We have authorization from the user.
            // We have to get the access token.
            $this->asanaAuth->getAccessToken($_GET['code']);
            // As Asana API documentation says, when response is successful, we receive a 200 in response so...
            if ($this->asanaAuth->hasError()) {
                echo 'Error while trying to connect to Asana to get the access token, response code: ' . $this->asanaAuth->responseCode;
                return;
            }
            $result = $this->asanaAuth->getData();
            $this->asana = $result;
            // Now we can create a normal asana object with the access token.
           $asana = new Asana(array('accessToken' => $result->access_token));
           $asana->getProjects();
           // As Asana API documentation says, when response is successful, we receive a 200 in response so...
           if ($asana->hasError()) {
               echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
               return;
           }
           // $asana->getData() contains an object in json with all projects
           foreach ($asana->getData() as $project) {
               echo 'Project ID: ' . $project->id . ' is ' . $project->name . '<br>' . PHP_EOL;
           }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
