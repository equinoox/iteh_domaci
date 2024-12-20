<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evets = Event::all();
        return $evets;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            // 'user_id' => 'required', Auth::
            'task_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $event = Event::create([
            'name' => $request->name,
            'date' => $request->date,
            'user_id' => $request->user_id,
            'task_id' => $request->task_id
        ]);

        return response()->json(['message' => 'Event Created.', 'task' => $event], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($event_id)
    {
        $event = Event::find($event_id);
        if(is_null($event)){
            return response()->json('Data not found.', 404);
        } else {
            return $event;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $event_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            // 'user_id' => 'required', Auth::
            'task_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $validated = $validator->validated();
        $event = Event::show($event_id);
        $updated_event = $event->update($validated);

        return response()->json(['message' => 'Event Updated.', 'user' => $updated_event], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($event_id)
    {
        $event = Event::show($event_id);
        $event->delete();
        return response()->json(['message' => 'Event Deleted.']);
    }
}
