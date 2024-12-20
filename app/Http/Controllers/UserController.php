<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'address_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'address_id' => $request->address_id,
        ]);

        return response()->json(['message' => 'User Created.', 'user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        $user = User::find($user_id);
        if(is_null($user)){
            return response()->json('Data not found.', 404);
        } else {
            return $user;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $user_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'address_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $validated = $validator->validated();
        $user = User::show($user_id);
        $updated_user = $user->update($validated);

        return response()->json(['message' => 'User Updated.', 'user' => $updated_user], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id)
    {
        $user = User::show($user_id);
        $user->delete();
        return response()->json(['message' => 'User Deleted.']);
    }
} 
