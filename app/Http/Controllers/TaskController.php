<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Task::all();
        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum registro encontrado',
            ], 404);
        }

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $data = $request->only([
            'name', 'description', 'status', 'file_url'
        ]);
        $task = Task::create($data);

        if (!$task) {
            return response()->json([
                'error' => 'Erro ao criar a tarefa'
            ], 400);
        }

        return response()->json($task, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $data = $request->only([
            'name', 'description', 'status', 'file_url'
        ]);

        if ($task->update($data)) {
            return response()->json($task, 200);
        }
        return response()->json(['error' => 'Erro ao atualizar'], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function patch(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $data = $request->only([
            'status'
        ]);

        // O status apenas pode ser alterado respeitando os estágios da tarefa:
        // BACKLOG -> IN_PROGRESS -> IN_PROGRESS -> WAITING_CUSTOMER_APPROVAL -> WAITING_CUSTOMER_APPROVAL -> APPROVED
        if ($task->status == 'BACKLOG' && $data['status'] == 'IN_PROGRESS') {
            $task->update($data);
            return response()->json($task, 200);
        }

        if ($task->status == 'IN_PROGRESS' && $data['status'] == 'WAITING_CUSTOMER_APPROVAL') {
            $task->update($data);
            return response()->json($task, 200);
        }

        if ($task->status == 'WAITING_CUSTOMER_APPROVAL' && $data['status'] == 'APPROVED') {
            $task->update($data);
            return response()->json($task, 200);
        }

        return response()->json(['error' => 'Erro ao atualizar'], 400);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}
