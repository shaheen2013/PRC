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
            $dbProject = Project::where('osusr_mlv_community_id', $request->osusr_mlv_community_id)->first();

            if ($dbProject) {
                $project = [];
                $projects = [];

                $dbProjects = Project::where('osusr_mlv_community_id', $request->osusr_mlv_community_id)->get();

                foreach ($dbProjects as $item) {
                    $projects[] = json_decode($this->asana->getProject($item->project_id),1);
                }

                $project[] = json_decode($this->asana->getProject($dbProject->project_id),1);

                $project['users'] = json_decode($this->asana->getWorkspaceUsers('25961259746709'));

                // Get sections
                $sections = [];
                $secctionData = json_decode($this->asana->getProjectSections($dbProject->project_id));
                $project['sections'] = $secctionData;

                foreach ($secctionData->data as $datum) {
                    $temp = [];
                    $tempTasks = [];
                    $temp[] = $datum;

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'https://app.asana.com/api/1.0/sections/'. $datum->gid .'/tasks');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

                    $headers = array();
                    $headers[] = 'Accept: application/json';
                    $headers[] = 'Authorization: Bearer '. env('ASANA_PAT');

                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = json_decode(curl_exec($ch), 1);

                    foreach ($result['data'] as $task) {
                        $tempTask = [];
                        $tempTask[] = json_decode($this->asana->getTask($task['gid']), 1);

                        if ($tempTask[0]['data']['parent'] == null) {
                            $subTasks = json_decode($this->asana->getSubTasks($task['gid']));
                            $comments = json_decode($this->asana->getTaskStories($task['gid']));
                            $tempTask['subTasks'] = count($subTasks->data);
                            $tempTask['comments'] = count($comments->data);
                            $tempTasks[] = $tempTask;
                        }
                    }

                    $temp['tasks'] = $tempTasks;
                    $sections[] = $temp;

                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    }

                    curl_close($ch);
                }

                $project['sectionData'] = $sections;

                return response()->json(['status' => 200, 'data' => ['project' => $project, 'projects' => $projects]], 200);
            } else {
                return response()->json(['status' => 200, 'data' => null], 200);
            }
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

            $this->asana->createSection($project->data->gid, ['name' => 'Sales']);
            $this->asana->createSection($project->data->gid, ['name' => 'Maintenance']);

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
        $project = [];

        $project[] = json_decode($this->asana->getProject($id),1);

        $project['users'] = json_decode($this->asana->getWorkspaceUsers('25961259746709'));

        // Get sections
        $sections = [];
        $secctionData = json_decode($this->asana->getProjectSections($id));
        $project['sections'] = $secctionData;

        foreach ($secctionData->data as $datum) {
            $temp = [];
            $tempTasks = [];
            $temp[] = $datum;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://app.asana.com/api/1.0/sections/'. $datum->gid .'/tasks');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Authorization: Bearer '. env('ASANA_PAT');

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = json_decode(curl_exec($ch), 1);

            foreach ($result['data'] as $task) {
                $tempTask = [];
                $tempTask[] = json_decode($this->asana->getTask($task['gid']), 1);

                if ($tempTask[0]['data']['parent'] == null) {
                    $subTasks = json_decode($this->asana->getSubTasks($task['gid']));
                    $comments = json_decode($this->asana->getTaskStories($task['gid']));
                    $tempTask['subTasks'] = count($subTasks->data);
                    $tempTask['comments'] = count($comments->data);
                    $tempTasks[] = $tempTask;
                }
            }

            $temp['tasks'] = $tempTasks;
            $sections[] = $temp;

            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }

            curl_close($ch);
        }

        $project['sectionData'] = $sections;

        return response()->json(['status' => 200, 'data' => $project], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get the resource
        try {
            $project = json_decode($this->asana->getProject($id), 1);

            return response()->json(['status' => 200, 'data' => $project['data']], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
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
        // Validate form data
        $rules = array(
            'name' => 'required|string|max:255',
            'workspace' => 'required|string',
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
            ];

            $project = json_decode($this->asana->updateProject($id, $data));

            return response()->json(['status' => 200, 'data' => $project], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->asana->deleteProject($id);
            Project::destroy(Project::where('project_id', $id)->value('id'));
            return response()->json(['status' => 200, 'data' => ''], 200);
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
    public function duplicate(Request $request)
    {
        // Validate form data
        $rules = array(
            'name' => 'required|string|max:255',
            'osusr_mlv_community_id' => 'required|integer',
        );

        $validator = Validator::make ( $request->all(), $rules);

        if ($validator->fails()){
            return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
        }

        // Create a new project
        try {
            $data = [
                'data' => [
                    'name' => $request->name,
                    "include" => array(
                        "members",
                        "task_notes",
                        "task_assignee",
                        "task_subtasks",
                        "task_attachments",
                        "task_dates",
                        "task_dependencies",
                        "task_followers",
                        "task_tags",
                        "task_projects"
                    ),
                    'schedule_dates' => [
                        'should_skip_weekends' => true,
                        'start_on' => date('Y-m-d'),
                    ]
                ]
            ];
            $data = json_encode($data);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://app.asana.com/api/1.0/projects/1124713106776588/duplicate');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);

            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Accept: application/json';
            $headers[] = 'Authorization: Bearer ' . env('ASANA_PAT');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $project = json_decode(curl_exec($ch));
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            $newProject = new Project();
            $newProject->osusr_mlv_community_id = $request->osusr_mlv_community_id;
            $newProject->project_id = $project->data->new_project->gid;
            $newProject->save();

            return response()->json(['status' => 200, 'data' => $project], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
    }
}
