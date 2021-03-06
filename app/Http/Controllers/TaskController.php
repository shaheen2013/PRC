<?php

namespace App\Http\Controllers;

use Asana;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Project;
use App\Accesstoken;
use App\Asanahelper;

class TaskController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all Asana tasks
        try {
            $tasks = $this->asana->getWorkspaceTasks();

            return response()->json(['status' => 200, 'data' => $tasks], 200);
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
                    $workspace[0]['projects'] = json_decode($this->asana->getProjectsInWorkspace($workspace[0]['gid']));
                    $workspace[0]['users'] = json_decode($this->asana->getWorkspaceUsers($workspace[0]['gid']));
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

        // Creates a task.
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

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://app.asana.com/api/1.0/sections/' . $request->section . '/addTask');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));

                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Bearer ' . $this->token;
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

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Validate form data
        $rules = array(
            'name' => 'nullable|string|max:255',
            'assignee' => 'nullable|string|max:255',
            'due_on' => 'nullable|integer',
            'notes' => 'nullable|string',
            'section' => 'nullable|string',
            'project' => 'required|string',
            'complete' => 'nullable|string|max:255',
        );

        $validator = Validator::make ( $request->all(), $rules);

        if ($validator->fails()){
            return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
        }

        try {
            // Get sections
            $sections = [];
            $secctionData = json_decode($this->asana->getProjectSections($request->project));

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
                $headers[] = 'Authorization: Bearer '. $this->token;

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = json_decode(curl_exec($ch), 1);

                foreach ($result['data'] as $task) {
                    $tempTask = [];
                    $data = json_decode($this->asana->getTask($task['gid']));

                    if ($data->data->parent == null) {
                        foreach ($request->all() as $index => $value) {
                            if (!empty($value) && $index != 'project') {
                                switch ($index) {
                                    case "name":
                                        if ($data->data->name || $data->data->notes) {
                                            if ($data->data->name) {
                                                if (strtolower($data->data->name) == strtolower($value)) {
                                                    $matched = true;
                                                } else {
                                                    if ($data->data->notes) {
                                                        if (strpos($data->data->notes, $value) !== false) {
                                                            $matched = true;
                                                        } else {
                                                            $matched = false;
                                                        }
                                                    } else {
                                                        $matched = false;
                                                    }
                                                }
                                            } else {
                                                if (strpos($data->data->notes, $value) !== false) {
                                                    $matched = true;
                                                } else {
                                                    $matched = false;
                                                }
                                            }
                                        } else {
                                            $matched = false;
                                        }
                                        break;
                                    case "assignee":
                                        if ($data->data->assignee) {
                                            if ($data->data->assignee->gid == $value) {
                                                $matched = true;
                                            } else {
                                                $matched = false;
                                            }
                                        } else {
                                            $matched = false;
                                        }
                                        break;
                                    case "due_on":
                                        if ($data->data->due_on) {
                                            if (strtotime($data->data->due_on) < time()) {
                                                $matched = false;
                                            } else {
                                                $now = new DateTime();
                                                $due_on = new DateTime($data->data->due_on);
                                                $interval = $now->diff($due_on);
                                                $days = $interval->format('%a');

                                                if ($value == 7) {
                                                    if ($days <= 7) {
                                                        $matched = true;
                                                    } else {
                                                        $matched = false;
                                                    }
                                                } elseif ($value == 30) {
                                                    if ($days <= 30) {
                                                        $matched = true;
                                                    } else {
                                                        $matched = false;
                                                    }
                                                } else {
                                                    if ($days <= 90) {
                                                        $matched = true;
                                                    } else {
                                                        $matched = false;
                                                    }
                                                }
                                            }
                                        } else {
                                            $matched = false;
                                        }
                                        break;
                                    case "notes":
                                        if ($data->data->notes) {
                                            if (strpos($data->data->notes, $value) !== false) {
                                                $matched = true;
                                            } else {
                                                $matched = false;
                                            }
                                        } else {
                                            $matched = false;
                                        }
                                        break;
                                    case "section":
                                        if (isset($data->data->memberships[0]->section)) {
                                            if ($data->data->memberships[0]->section->gid == $value) {
                                                $matched = true;
                                            } else {
                                                $matched = false;
                                            }
                                        } else {
                                            $matched = false;
                                        }
                                        break;
                                    case "complete":
                                        if ($value == 'all') {
                                            $matched = true;
                                        } elseif ($value == 'true') {
                                            if ($data->data->completed) {
                                                $matched = true;
                                            } else {
                                                $matched = false;
                                            }
                                        } else {
                                            if (!$data->data->completed) {
                                                $matched = true;
                                            } else {
                                                $matched = false;
                                            }
                                        }
                                        break;
                                    default:
                                }

                                if (!$matched) {
                                    break;
                                }
                            }
                        }

                        if (isset($matched)) {
                            if ($matched) {
                                $subTasks = json_decode($this->asana->getSubTasks($task['gid']));
                                $comments = json_decode($this->asana->getTaskStories($task['gid']));
                                $tempTask[] = $data;
                                $tempTask['subTasks'] = count($subTasks->data);
                                $tempTask['comments'] = count($comments->data);
                                $tempTasks[] = $tempTask;
                            }
                        } else {
                            $subTasks = json_decode($this->asana->getSubTasks($task['gid']));
                            $comments = json_decode($this->asana->getTaskStories($task['gid']));
                            $tempTask[] = $data;
                            $tempTask['subTasks'] = count($subTasks->data);
                            $tempTask['comments'] = count($comments->data);
                            $tempTasks[] = $tempTask;
                        }
                    }
                }

                $temp['tasks'] = $tempTasks;
                $sections[] = $temp;

                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }

                curl_close($ch);
            }

            return response()->json(['status' => 200, 'data' => $sections], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
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
            $task = json_decode($this->asana->getTask($id), 1);

            return response()->json(['status' => 200, 'data' => $task['data']], 200);
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
            'name' => 'nullable|string|max:255',
            'assignee' => 'nullable|string|max:255',
            'due_on' => 'nullable|date',
            'notes' => 'nullable|string',
            'section' => 'nullable|string',
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

            if (isset($request->section) && !empty($request->section)) {
                $param = [
                    'data' => [
                        'task' => $id,
                    ]
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://app.asana.com/api/1.0/sections/' . $request->section . '/addTask');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));

                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Accept: application/json';
                $headers[] = 'Authorization: Bearer ' . $this->token;

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                $task = json_decode($this->asana->getTask($id), 1);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete specified task
        try {
            $this->asana->deleteTask($id);

            return response()->json(['status' => 200, 'data' => ''], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Int $id
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        try {
            $data = [];
            $tempComments = [];
            $task[] = json_decode($this->asana->getTask($id));
            $subTasks = json_decode($this->asana->getSubTasks($id));
            $comments = json_decode($this->asana->getTaskStories($id));

            foreach ($comments->data as $comment) {
                $tempComment = [];

                if ($comment->type == 'comment') {
                    $tempComment[] = $comment;
                    $tempComment['details'] = json_decode($this->asana->getSingleStory($comment->gid));
                } else {
                    $tempComment[] = $comment;
                }

                $tempComments[] = $tempComment;
            }

            foreach ($subTasks->data as $datum) {
                $temp = [];
                $temp[] = json_decode($this->asana->getTask($datum->gid));
                $count = json_decode($this->asana->getTaskStories($datum->gid), 1);
                $temp['comments'] = count($count['data']);
                $data[] = $temp;
            }

            $task['subTasks'] = $data;
            $task['comments'] = $tempComments;

            return response()->json(['status' => 200, 'data' => $task], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
    }

    /**
     * Store a newly created attachment in storage.
     *
     * @param $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function attachment(Request $request, $id)
    {
        // Validate form data
        $rules = array(
            'file' => 'required|file|max:100000',
        );

        $validator = Validator::make ( $request->all(), $rules);

        if ($validator->fails()){
            return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
        }

        // Attach an attachment to task.
        try {
            $data = [
                'file' => $request->file('file'),
                'mimeType' => $request->file('file')->getMimeType(),
                'finalFilename' => $request->file('file')->getClientOriginalName()
            ];

            $this->asana->addAttachmentToTask($id, $data);

            return response()->json(['status' => 200, 'data' => []], 200);
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
    public function subtasks(Request $request, $id)
    {
        // Validate form data
        $rules = array(
            'name' => 'nullable|string|max:255',
            'assignee' => 'nullable|string|max:255',
            'due_on' => 'nullable|date',
            'project' => 'required|string',
        );

        $validator = Validator::make ( $request->all(), $rules);

        if ($validator->fails()){
            return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
        }

        // Creates a task.
        try {
            $data = [
                'name' => $request->name,
                'projects' => [$request->project],
                'assignee' => $request->assignee,
                'due_on' => $request->due_on,
            ];

            $task[] = json_decode($this->asana->createSubTask($id, $data), 1);
            $task['comments'] = json_decode($this->asana->getTaskStories($task[0]['data']['gid']));

            return response()->json(['status' => 200, 'data' => $task], 200);
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
    public function stories(Request $request, $id)
    {
        // Validate form data
        $rules = array(
            'taskComment' => 'required|string',
        );

        $validator = Validator::make ( $request->all(), $rules);

        if ($validator->fails()){
            return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
        }

        // Creates a task.
        try {
            json_decode($this->asana->commentOnTask($id, $request->taskComment), 1);
            $comments = json_decode($this->asana->getTaskStories($id));
            foreach ($comments->data as $comment) {
                $tempComment = [];
                $tempComment[] = $comment;

                if ($comment->type == 'comment') {
                    $tempComment['details'] = json_decode($this->asana->getSingleStory($comment->gid));
                }
                
                $tempComments[] = $tempComment;
            }

            return response()->json(['status' => 200, 'data' => $tempComments], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        // Validate form data
        $rules = array(
            'due_on' => 'nullable|string',
            'project' => 'required|string',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
        }

        try {
            $data = [];
            $tasks = [];
            $tempTasks = json_decode($this->asana->getProjectTasks($request->project), 1);

            foreach ($tempTasks['data'] as $tempTask) {
                $temp = json_decode($this->asana->getTask($tempTask['gid']), 1);

                if ($temp['data']['parent'] == null && $temp['data']['due_on'] != null) {
                    $data[] = $temp['data'];
                }
            }

            $sortedArr = collect($data)->sortBy('due_on')->values();

            foreach ($sortedArr as $value) {
                $tempTask = [];
                $tempTask[] = $value;

                $subTasks = json_decode($this->asana->getSubTasks($value['gid']));
                $comments = json_decode($this->asana->getTaskStories($value['gid']));
                $tempTask['subTasks'] = count($subTasks->data);
                $tempTask['comments'] = count($comments->data);
                $tasks[] = $tempTask;
            }

            // Get sections
            $sections = [];
            $secctionData = json_decode($this->asana->getProjectSections($request->project));

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
                $headers[] = 'Authorization: Bearer '. $this->token;

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = json_decode(curl_exec($ch), 1);

                foreach ($result['data'] as $task) {
                    $tempTask = [];
                    $tempTask[] = json_decode($this->asana->getTask($task['gid']), 1);

                    if ($tempTask[0]['data']['parent'] == null && $tempTask[0]['data']['due_on'] == null) {
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

            return response()->json(['status' => 200, 'data' => ['tasks' => $tasks, 'sections' => $sections]], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()], 200);
        }
    }
}
