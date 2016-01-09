<?php

namespace App\Http\Controllers;

use App\Acme\Transformers\TaskTransformer;
use App\Task;
use Illuminate\Http\Request;

use App\Http\Requests;
use Response;

class TaskController extends ApiController
{
    protected $taskTranformer;

    function __construct(TaskTransformer $taskTransformer)
    {
        $this->taskTransformer = $taskTransformer;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return $this->respond([

           'data' => $this->taskTransformer->transformCollection($tasks)

        ]);

        //return Acme::all();
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
        $task = new Task();
        $this->saveTask($request, $task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task)
        {
            return $this->respondNotFound('Task does not exist');
        }

        return $this->respond([

            'data' => $this->taskTransformer->transform($task)

        ]);
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
        $task = Task::find($id);

        if (!$task)
        {
            return $this->respondNotFound('Task does not exist!!');
        }

        $this->saveTask($request, $task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
    }

    /**
     * @param Request $request
     * @param $task
     */
    public function saveTask(Request $request, $task)
    {
        $task->name = $request->name;
        $task->priority = $request->priority;
        $task->done = $request->done;

        $task->save();
    }
}
