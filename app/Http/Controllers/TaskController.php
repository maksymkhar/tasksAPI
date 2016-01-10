<?php

namespace App\Http\Controllers;

use App\Acme\Transformers\TaskTransformer;
use App\Task;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Response;

class TaskController extends ApiController
{
    protected $taskTranformer;

    function __construct(TaskTransformer $taskTransformer)
    {
        $this->taskTransformer = $taskTransformer;

        $this->middleware('auth.basic', ['only' => 'store']);
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
    public function store()
    {
        if (!Input::get('name') or !Input::get('priority') or !Input::get('done'))
        {
            return $this->setStatusCode(422)->respondWithError('Parameters failed validation for a task');
        }

        Task::create(Input::all());

        return $this->respondCreated('Task successfully created.');
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
}
