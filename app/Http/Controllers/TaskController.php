<?php

namespace App\Http\Controllers;

use Asana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
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
                'workspace' => $request->workspace,
                'projects' => [$request->project],
                'assignee' => $request->assignee,
                'due_on' => $request->due_on,
                'notes' => $request->notes,
            ];

            $task = json_decode($this->asana->createTask($data), 1);

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
            $headers[] = 'Authorization: Bearer ' . env('ASANA_PAT');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

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
            'due_on' => 'nullable|date',
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
            $tasks = json_decode($this->asana->getProjectTasks($request->project));
            $response = [];

            foreach ($tasks->data  as $task) {
                $data = json_decode($this->asana->getTask($task->gid));

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
                                    if ($data->data->due_on == $value) {
                                        $matched = true;
                                    } else {
                                        $matched = false;
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
                                if ($value == 'true') {
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
                        $response[] = $data;
                    }
                } else {
                    $response[] = $data;
                }
            }

            return response()->json(['status' => 200, 'data' => $response], 200);
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
            'workspace' => 'required|string',
        );

        $validator = Validator::make ( $request->all(), $rules);

        if ($validator->fails()){
            return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
        }

        // Update a task.
        try {
            $data = [];

            foreach ($request->all() as $key => $item) {
                if ($key != '_method' || $key != 'section') {
                    if (!empty($item)) {
                        $data[$key] = $item;
                    }
                }
            }

            $task = json_decode($this->asana->updateTask($id, $data), 1);

            if (isset($request->section)) {
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
                $headers[] = 'Authorization: Bearer ' . env('ASANA_PAT');

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
            $task[] = json_decode($this->asana->getTask($id));
            $subTasks = json_decode($this->asana->getSubTasks($id));

            foreach ($subTasks->data as $datum) {
                $data[] = json_decode($this->asana->getTask($datum->gid));
            }

            $task['subTasks'] = $data;

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
}
