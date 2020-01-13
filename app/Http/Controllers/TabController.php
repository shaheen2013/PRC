<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Asana;
use App\Project;
use App\Accesstoken;
use App\Asanahelper;

class TabController extends Controller
{
    private $asana;
    private $token;

    public function __construct()
    {
        $asana = new Asanahelper();
        $response = json_decode($asana->accessToken('1151360720602219'));
        if($response->access_token){
            $this->asana = new Asana(['personalAccessToken' => $response->access_token]);
            $this->token = $response->access_token;
        }else{
            $this->asana = false;
        }
    }

    public function index(Request $request){

        try {
            // Get all projects by community_id
            $dbProjects = Project::where('osusr_mlv_community_id', $request->osusr_mlv_community_id)->get();

            if ($dbProjects->count() > 0) {
                foreach ($dbProjects as $item) {
                    $ap = json_decode($this->asana->getProject($item->project_id),1);  
                    $apFiltered = [
                        'gid' => $ap['data']['gid'],
                        'name' => $ap['data']['name'],
                        'comminity_id' => $item->osusr_mlv_community_id,
                        'workspace_id' => $ap['data']['workspace']['gid'],
                        'sections' => []
                    ];
                    $asanaProj[] = $apFiltered;
                }
                return response()->json(['status' => 200, 'data' => $asanaProj], 200);
            } else {
                return response()->json(['status' => 200, 'data' => null], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
        return response()->json(['status' => 200, 'data' => null], 200);
    }
    public function users(){
        return $this->asana->getWorkspaceUsers('25961259746709');
    }
    public function getSections($id){
        return response()->json(['status' => 200, 'data' => json_decode($this->asana->getProjectSections($id)), 'projectGid' => $id], 200);
    }
    public function getTasks($id){
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer '. $this->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://app.asana.com/api/1.0/sections/'. $id .'/tasks');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = json_decode(curl_exec($ch), 1);
        $tasks = [];
        foreach ($result['data'] as $key => $task) {
            $tempTask = json_decode($this->asana->getTask($task['gid']), 1);
            // dd($task['gid']);
            $taskArr = [];
            $taskArr['details'] = $task;
            if($tempTask['data']){
                $subTasks = json_decode($this->asana->getSubTasks($task['gid']));
                $comments = json_decode($this->asana->getTaskStories($task['gid']));
                $taskArr['subTasks'] = count($subTasks->data);
                $taskArr['comments'] = count($comments->data);
                $taskArr['completed'] = $tempTask['data']['completed'];
                $taskArr['assignee'] = $tempTask['data']['assignee'] ? $tempTask['data']['assignee'] : ['gid' => null, 'name' => null, 'resource_type' => "user"];
                $taskArr['duedate'] = $tempTask['data']['due_on'];
            }
            $tasks[] = $taskArr;
        }

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return response()->json(['status' => 200, 'data' => $tasks, 'section_id' => $id], 200);
    }
    public function storeTasks(Request $request)
    {
        $rules = array(
            'name' => 'nullable|string|max:255',
            'assignee' => 'nullable|string|max:255',
            'due_on' => 'nullable|date',
            'notes' => 'nullable|string',
            'section' => 'nullable|string',
            'workspace' => 'required|string',
            'projects' => 'required|array',
        );
        $validator = Validator::make ( $request->all(), $rules);
        if ($validator->fails()){
            return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
        }

        try {
            $data = [];
            foreach ($request->all() as $key => $item) {
                if ($key != 'section') {
                    if (!empty($item)) {
                        $data[$key] = $item;
                    }
                }
            }
            $task = json_decode($this->asana->createTask($data), 1);

            if (isset($request->section) && !empty($request->section)) {
                $param = [
                    'data' => [
                        'task' => $task['data']['gid'],
                    ]
                ];
                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Bearer ' . $this->token;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://app.asana.com/api/1.0/sections/' . $request->section . '/addTask');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
            }

            return response()->json(['status' => 200, 'data' => $task], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
    }
    public function updateTask(Request $request, $id)
    {
        $rules = array(
            'name' => 'nullable|string|max:255',
            'assignee' => 'nullable|string|max:255',
            'due_on' => 'nullable|date',
            'notes' => 'nullable|string',
            'section' => 'nullable|string',
            'completed' => 'nullable|boolean',
        );
        $validator = Validator::make ( $request->all(), $rules);
        if ($validator->fails()){
            return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
        }
        // Update a task.
        try {
            $data = $request->all();

            foreach ($data as $key => $item) {
                if ($key == '_method' || $key == 'section' || $key == 'id') {
                    unset($data[$key]);
                }
            }
            $task = json_decode($this->asana->updateTask($id, $data), 1);
            return response()->json(['status' => 200, 'data' => $task], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
    }
}
