<?php

namespace App\Http\Controllers;

use Asana;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->asana = new Asana([
            'personalAccessToken' => env('ASANA_PAT')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get all Asana projects
        try {
            // Get all projects by community_id
            $dbProjects = Project::where('osusr_mlv_community_id', $request->osusr_mlv_community_id)->get();

            $projects = [];

            foreach ($dbProjects as &$project) {
                $pj = json_decode($this->asana->getProject($project->project_id), 1);
                $pj['tasks'] = json_decode($this->asana->getProjectTasks($pj['data']['gid']), 1);
                $projects[] = $pj;
            }

            return response()->json(['status' => 200, 'data' => $projects], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get required resource
        try {
            $workspaces = json_decode($this->asana->getWorkspaces(), 1);

            foreach ($workspaces as &$workspace) {
                if(isset($workspace[0])){
                    $workspace[0]['teams'] = json_decode($this->asana->getMyTeams($workspace[0]['gid']));
                }
            }

            return response()->json(['status' => 200, 'data' => $workspaces], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate form data
        $rules = array(
            'name' => 'required|string|max:255',
            'workspace' => 'required|string',
            'team' => 'required|string',
            'osusr_mlv_community_id' => 'required|integer',
        );

        $validator = Validator::make ( $request->all(), $rules);

        if ($validator->fails()){
            return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
        }

        // Create a new project
        try {
            $data = [
                'name' => $request->name,
                'workspace' => $request->workspace,
                'team' => $request->team,
            ];

            $project = json_decode($this->asana->createProject($data));

            $newProject = new Project();
            $newProject->osusr_mlv_community_id = $request->osusr_mlv_community_id;
            $newProject->project_id = $project->data->gid;
            $newProject->save();

            return response()->json(['status' => 200, 'data' => $project], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
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
