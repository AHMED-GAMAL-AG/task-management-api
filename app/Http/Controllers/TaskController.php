<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:in progress,completed,pending',
            'due_date' => 'required|date',
        ]);

        return Task::create($validatedData);
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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:in progress,completed,pending',
            'due_date' => 'required|date',
        ]);

        $task->update($validatedData);
        return $task;
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
    public function tasksDueWithinRange(Request $request)
    {
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        return Task::whereBetween('due_date', [$validatedData['start_date'], $validatedData['end_date']])->get();
    }
}
