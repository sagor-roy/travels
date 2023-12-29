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


Route::get('/test', function () {
    $limit = request('limit', 10);
    $search = request('search', "");

    return Test::when(!empty($search), function ($query) use ($search) {
        return $query->where('title', 'LIKE', "%$search%")
            ->orWhere('year', 'LIKE', "%$search%");
    })->paginate($limit);
});


Route::post('/excel-store', function (Request $request) {
    $request->validate([
        'file' => 'required|file|mimes:xlsx',
    ]);

    $file = $request->file('file');
    $data = Excel::toArray([], $file);

    foreach (array_slice($data[0], 1) as $row) {
        Test::create([
            'title' => $row[0],
            'year' => $row[1],
        ]);
    }

    return response()->json(['success' => 'Data imported successfully'], 200);
});

Route::delete('/delete', function (Request $request) {
    $data = $request->json('selectedRows');
    Test::whereIn('id', $data)->delete();
    return response()->json(['success' => 'Data deleted successfully'], 200);
});


Route::resource('/destination', DestinationController::class);
Route::put('/destination/status/{id}', [DestinationController::class,'status']);
Route::post('/destination/multiple-delete', [DestinationController::class,'multi_destroy']);
