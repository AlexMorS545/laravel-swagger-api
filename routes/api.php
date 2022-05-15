<?php

use App\Http\Controllers\API\CarController;
use App\Http\Controllers\API\DriverController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::apiResource('users', UserController::class);
Route::apiResource('cars', CarController::class);

Route::get('/available-cars', [DriverController::class, 'availableCars']);
Route::get('/remove-car/{car_id}', [DriverController::class, 'removeCar']);
Route::get('/drive/{user_id}/{car_id}', [DriverController::class, 'driveCar']);
