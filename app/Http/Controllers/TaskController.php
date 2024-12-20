<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id
        ]);

        return response()->json(['message' => 'Task Created.', 'task' => $task], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($task_id)
    {
        $task = Task::find($task_id);
        if(is_null($task)){
            return response()->json('Data not found.', 404);
        } else {
            return $task;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $task_id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $validated = $validator->validated();
        $task = Task::show($task_id);
        $updated_task = $task->update($validated);

        return response()->json(['message' => 'Task Updated.', 'user' => $updated_task], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($task_id)
    {
        $task = Task::show($task_id);
        $task->delete();
        return response()->json(['message' => 'Task Deleted.']);
    }
}
