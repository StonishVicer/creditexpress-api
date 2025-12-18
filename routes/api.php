<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CustomersController;

Route::get('/customers', [CustomersController::class, 'index']);
Route::get('/customers/{id}', [CustomersController::class, 'show']);
Route::post('/customers', [CustomersController::class, 'store']);
Route::delete('/customers/{id}', [CustomersController::class, 'destroy']);
Route::put('/customers/{id}', [CustomersController::class, 'update']);
Route::patch('/customers/{id}', [CustomersController::class, 'updatePartial']);
