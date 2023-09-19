<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\TaskRequestStore;
use App\Http\Requests\api\TaskRequestUpdate;
use App\Models\Task;
use App\Http\Resources\api\TaskResource;
use App\Http\Resources\api\TaskListResource;

    class TaskController extends Controller
    {
        public function index()
        {
            $tasks = Task::all();
            return new TaskListResource($tasks);
        }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return new TaskResource($task);
    }

    public function store(TaskRequestStore $request)
    {
        $data = $request->validated();
        $task = Task::create($data);

        return new TaskResource($task);
    }

    public function update(TaskRequestUpdate $request, $id)
    {
        $data = $request->validated();
        $task = Task::findOrFail($id);

        $task->update($data);

        return new TaskResource($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task has been deleted']);
    }
}