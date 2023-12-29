<?php

use App\Http\Controllers\API\Backend\DestinationController;
use App\Imports\TestImport;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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


Route::resource('/destination', DestinationController::class);
Route::put('/destination/status/{id}', [DestinationController::class,'status']);
Route::post('/destination/excel-store', [DestinationController::class,'excel_store']);
