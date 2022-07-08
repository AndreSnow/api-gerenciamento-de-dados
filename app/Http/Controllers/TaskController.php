<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Traits\StatusTrait;
use App\Models\TagsTask;
use App\Models\Task;

class TaskController extends Controller
{
    use StatusTrait;

    protected $entity, $model;

    /**
     * TaskController constructor.
     * @param Task $model
     */
    public function __construct()
    {
        $this->entity = app(Task::class);
        $this->model = app(TagsTask::class);
    }

    /**
     * Display a listing of tasks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->entity::all([
            'id', 'name', 'description', 'status'
        ]);

        if ($tasks->isEmpty()) {
            return response()->json([
                'error' => 'Nenhuma tarefa encontrada'
            ], 404);
        }

        foreach ($tasks as $task) {
            $task->tags = $this->model::where('task_id', $task->id)
                ->get(['tag_name']);
        }

        return response()->json($tasks, 200);
    }

    /**
     * Display a listing of approved tasks.
     *
     * @return \Illuminate\Http\Response
     */
    public function listApproved($request)
    {
        $tasks = $this->entity::all()->where('id', $request)
            ->where('status', 'approved');

        if ($tasks->isEmpty()) {
            return response()->json([
                'error' => 'Nenhuma tarefa encontrada'
            ], 404);
        }

        return response()->json($tasks, 200);
    }

    /**
     * Store a newly created resource in tarefas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $data = $request->only([
            'name', 'description', 'status', 'file_url'
        ]);

        if (!isset($data['status'])) {
            $data['status'] = 'backlog';
        }

        $task = $this->entity::create($data);

        if (!$task) {
            return response()->json([
                'error' => 'Erro ao criar a tarefa'
            ], 422);
        }

        return response()->json($task, 201);
    }

    /**
     * Store a newly created resource in tag.
     * @param  int  $id
     */
    public function storeTag(TagRequest $request)
    {
        $data = $request->only([
            'tag_name', 'task_id'
        ]);

        if (!$this->entity::find($data['task_id'])) {
            return response()->json([
                'error' => 'Tarefa não encontrada'
            ], 404);
        }
        $tag = $this->model::create($data);
        if (!$tag) {
            return response()->json([
                'error' => 'Erro ao criar a tag'
            ], 422);
        }

        return response()->json('', 204);
    }

    /**
     * Update the specified task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        if ($request->has('status')) {
            $task = $this->getStatusAttribute($request, $id);
            return $task;
        }

        $task = $this->entity::findOrFail($id);
        $data = $request->only([
            'name', 'description', 'status', 'file_url'
        ]);

        $task->update($data);

        return response()->json('', 204);
    }

    /**
     * Update the status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function patch(TaskRequest $request, $id)
    {
        if (!$request->has('status')) {
            return response()->json([
                'error' => 'Status não informado'
            ], 422);
        }
        $task = $this->getStatusAttribute($request, $id);

        return $task;
    }
}
