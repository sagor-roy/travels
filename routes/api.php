<?php

use App\Http\Controllers\API\Backend\DestinationController;
use App\Http\Controllers\API\Backend\RouteController;
use App\Http\Controllers\API\Backend\ScheduleController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// destination
Route::resource('/destination', DestinationController::class)->except(['show', 'create']);
Route::put('/destination/status/{id}', [DestinationController::class, 'status']);
Route::post('/destination/excel-store', [DestinationController::class, 'excel_store']);

// route
Route::resource('/route', RouteController::class)->except(['show']);
Route::put('/route/status/{id}', [RouteController::class, 'status']);
Route::post('/route/excel-store', [RouteController::class, 'excel_store']);

// schedule
Route::resource('/schedule', ScheduleController::class)->except(['show', 'create']);
Route::post('/schedule/excel-store', [ScheduleController::class, 'excel_store']);
