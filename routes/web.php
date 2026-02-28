<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\vueController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/crud', function () {
    return view('vuetest');
});



    Route::get('/users', [vueController::class, 'index']);
    Route::post('/users', [vueController::class, 'store']);
    Route::put('/users/{id}', [vueController::class, 'update']);
    Route::delete('/users/{id}', [vueController::class, 'destroy']);
    Route::post('/users/delete-multiple', [vueController::class, 'deleteMultiple']);


// Route::get('/users', [newVueController::class, 'index']);
// Route::post('/users', [newVueController::class, 'store']);
// Route::put('/users/{id}', [newVueController::class, 'update']);
// Route::delete('/users/{id}', [newVueController::class, 'destroy']);