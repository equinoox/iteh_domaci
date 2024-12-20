<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// apiResource generise RESTful rute, ali iskljucuje rute koje nisu za API

Route::apiResource('/users', UserController::class);
Route::apiResource('/addresses', AddressController::class);
Route::apiResource('/tasks', TaskController::class);
Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/events', EventController::class);

// Posebne rute
