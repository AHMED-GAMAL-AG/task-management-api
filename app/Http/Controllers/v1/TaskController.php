<?php

namespace App\Http\Controllers\v1;

use App\Http\Resources\TaskResource;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 6);
        $sortBy = $request->query('sort_by', 'due_date');
        $sortOrder = $request->query('sort_order');

        // Validate sorting parameters
        $validSortColumns = ['due_date', 'status'];
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : null;
        $sortBy = in_array($sortBy, $validSortColumns) ? $sortBy : 'due_date';

        // Apply default sorting order if not specified
        if (!$sortOrder) {
            $sortOrder = $sortBy === 'due_date' ? 'asc' : 'desc';
        }

        return Task::orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:in progress,completed,pending', // in: This rule specifies a list of allowed values for the 'status' field.
            'due_date' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $task = Task::create($request->all());
        return response()->json($task, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:in progress,completed,pending', // in: This rule specifies a list of allowed values for the 'status' field.
            'due_date' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $task->update($request->all());
        return response()->json($task, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

    /**
     * Retrieve tasks by status (e.g., "in progress," "completed").
     */
    public function tasksByStatus($status)
    {
        return Task::where('status', $status)->get();
    }

    /**
     * Retrieve tasks that are due within a specified date range.
     */
    public function tasksDueWithinRange($date)
    {
        return Task::where('due_date', $date)->get();
    }
}
