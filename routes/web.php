<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\AllRoleController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CreateRoleController;
use App\Http\Controllers\Backend\DestinationController;
use App\Http\Controllers\Backend\FleetTypeController;
use App\Http\Controllers\Backend\RouteController;
use App\Http\Controllers\Backend\ScheduleController;
use App\Http\Controllers\Backend\TripController;
use App\Http\Controllers\Backend\VehiclesController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

// frotnend
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('login', 'login')->name('login');
    Route::get('search', 'search')->name('search');
    Route::get('trip/data/{id}', 'trip');
    Route::get('session/destroy', 'destroy')->name('session.destroy');
    Route::post('seat/count', 'seatCount')->name('seat.count');
    Route::post('invoice', 'order')->name('order');
    Route::get('download/{id}', 'download')->name('download');
});

// auth
Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('access', 'access')->name('access');
});


// backend
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // dashboard
    Route::get('dashboard', [BackendController::class, 'index'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    //fleet manage
    Route::prefix('fleet')->name('fleet.')->group(function () {
        //fleet type
        Route::prefix('type')->name('type.')->controller(FleetTypeController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store', 'store')->name('store');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
            Route::put('status/{id}', 'status');
        });

        //vehicles
        Route::prefix('vehicles')->name('vehicles.')->controller(VehiclesController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store', 'store')->name('store');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
            Route::put('status/{id}', 'status');
        });
    });

    //trip manage
    Route::prefix('trip')->name('trip.')->group(function () {
        //destination
        Route::prefix('destination')->name('dest.')->controller(DestinationController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store', 'store')->name('store');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
            Route::put('status/{id}', 'status');
        });

        //route
        Route::prefix('route')->name('route.')->controller(RouteController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store', 'store')->name('store');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
            Route::put('status/{id}', 'status');
        });

        //schedule
        Route::prefix('schedule')->name('schedule.')->controller(ScheduleController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store', 'store')->name('store');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
        });

        //trip
        Route::controller(TripController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store', 'store')->name('store');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
            Route::put('status/{id}', 'status');
        });
    });

    
    //role manage
    Route::prefix('role')->name('role.')->group(function () {
        //all role
        Route::prefix('all')->name('all.')->controller(AllRoleController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store', 'store')->name('store');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
        });

        //create role
        Route::prefix('create')->name('create.')->controller(CreateRoleController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store', 'store')->name('store');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('destroy');
        });
    });
});
