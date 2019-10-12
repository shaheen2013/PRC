<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Create a new project
        /*$data = [
            'name' => 'Project 2',
            'workspace' => '1144115702042051',
            'team' => '1144115702042053',
        ];

        $asana->createProject($data);*/

        //Creates a task.
        /*$data = [
            'name' => 'Hello, world!',
            'workspace' => '1144115702042051',
            'projects' => '1144158634780510',
        ];

        $asana->createTask($data);
        dd($asana);*/

        return redirect('/admin');
    }

    public function syncContacts()
    {
        return view('syncContacts');
    }
}
