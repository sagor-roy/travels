<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\DestinationController;
use App\Http\Controllers\Backend\FleetTypeController;
use App\Http\Controllers\Backend\RouteController;
use App\Http\Controllers\Backend\ScheduleController;
use App\Http\Controllers\Backend\VehiclesController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

// frotnend
Route::get('/',[HomeController::class,'index'])->name('home');


// backend
Route::prefix('admin')->name('admin.')->group(function(){
    // dashboard
    Route::get('dashboard',[BackendController::class,'index'])->name('dashboard');

    //fleet manage
    Route::prefix('fleet')->name('fleet.')->group(function(){
        //fleet type
        Route::prefix('type')->name('type.')->controller(FleetTypeController::class)->group(function(){
            Route::get('/','index')->name('index');
            Route::get('create','create')->name('create');
            Route::get('edit/{id}','edit')->name('edit');
            Route::post('store','store')->name('store');
            Route::put('update/{id}','update')->name('update');
            Route::delete('delete/{id}','destroy')->name('destroy');
            Route::put('status/{id}','status');
        });

        //vehicles
        Route::prefix('vehicles')->name('vehicles.')->controller(VehiclesController::class)->group(function(){
            Route::get('/','index')->name('index');
            Route::get('create','create')->name('create');
            Route::get('edit/{id}','edit')->name('edit');
            Route::post('store','store')->name('store');
            Route::put('update/{id}','update')->name('update');
            Route::delete('delete/{id}','destroy')->name('destroy');
            Route::put('status/{id}','status');
        });

    });

    //trip manage
    Route::prefix('trip')->name('trip.')->group(function(){
        //destination
        Route::prefix('destination')->name('dest.')->controller(DestinationController::class)->group(function(){
            Route::get('/','index')->name('index');
            Route::get('create','create')->name('create');
            Route::get('edit/{id}','edit')->name('edit');
            Route::post('store','store')->name('store');
            Route::put('update/{id}','update')->name('update');
            Route::delete('delete/{id}','destroy')->name('destroy');
            Route::put('status/{id}','status');
        });

        //route
        Route::prefix('route')->name('route.')->controller(RouteController::class)->group(function(){
            Route::get('/','index')->name('index');
            Route::get('create','create')->name('create');
            Route::get('edit/{id}','edit')->name('edit');
            Route::post('store','store')->name('store');
            Route::put('update/{id}','update')->name('update');
            Route::delete('delete/{id}','destroy')->name('destroy');
            Route::put('status/{id}','status');
        });

        //schedule
        Route::prefix('schedule')->name('schedule.')->controller(ScheduleController::class)->group(function(){
            Route::get('/','index')->name('index');
            Route::get('create','create')->name('create');
            Route::get('edit/{id}','edit')->name('edit');
            Route::post('store','store')->name('store');
            Route::put('update/{id}','update')->name('update');
            Route::delete('delete/{id}','destroy')->name('destroy');
        });
    });
});
