<?php

namespace App\Http\Traits;

use App\Http\Requests\TaskRequest;
use App\Models\Task;

trait StatusTrait
{
    /**
     * Garante que o status siga o padrão de atualização.
     * @param TaskRequest $request
     * @return array
     */
    public function getStatusAttribute(TaskRequest $request, $id)
    {
        if ($request->method() == 'PATCH') {
            $task = Task::findOrFail($id);
            $data = $request->only([
                'status'
            ]);

            if ($task->status == 'backlog' && $data['status'] == 'in_progress') {
                $task->update($data);
                return response()->json('', 204);
            } elseif ($task->status == 'in_progress' && $data['status'] == 'waiting_customer_approval') {
                $task->update($data);
                return response()->json('', 204);
            } elseif ($task->status == 'waiting_customer_approval' && $data['status'] == 'approved') {
                $task->update($data);
                return response()->json('', 204);
            }
            return response()->json([
                'error' => 'Status não permitido'
            ], 422);
        }
        
        $task = Task::findOrFail($id);
        $data = $request->only([
            'name', 'description', 'status', 'file_url'
        ]);

        if ($task->status == 'backlog' && $data['status'] == 'in_progress') {
            $task->update($data);
            return response()->json('', 204);
        } elseif ($task->status == 'in_progress' && $data['status'] == 'waiting_customer_approval') {
            $task->update($data);
            return response()->json('', 204);
        } elseif ($task->status == 'waiting_customer_approval' && $data['status'] == 'approved') {
            $task->update($data);
            return response()->json('', 204);
        }
        return response()->json([
            'error' => 'Status não permitido'
        ], 422);
    }
}
