<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\TaskRequestStore;
use App\Http\Requests\api\TaskRequestUpdate;
use App\Models\Task;
use App\Http\Resources\api\TaskResource;
use App\Http\Resources\api\TaskListResource;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Task::query();

            if ($request->has('completed')) {
                $completed = $request->boolean('completed');
                $query->where('completed', $completed);
            }

            if ($request->has('endDate')) {
                $endDate = $request->input('endDate');

                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
                    $query->whereDate('endDate', '=', $endDate);
                }
            }

            if ($request->has('sort') && in_array($request->input('sort'), ['asc', 'desc'])) {
                $sortDirection = $request->input('sort');
                $query->orderBy('endDate', $sortDirection);
            }

            $tasks = $query->get();

            return new TaskListResource($tasks);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $task = Task::findOrFail($id);
            return new TaskResource($task);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(TaskRequestStore $request)
    {
        try {
            $data = $request->validated();
            $task = Task::create($data);
            return new TaskResource($task);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(TaskRequestUpdate $request, $id)
    {
        try {
            $data = $request->validated();
            $task = Task::findOrFail($id);
            $task->update($data);
            return new TaskResource($task);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return response()->json(['message' => 'Task has been deleted']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}