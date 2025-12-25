<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CustomersController;
use App\Http\Controllers\Api\LoansController;
use App\Http\Controllers\Api\LoansStatusController;

Route::get('/customers', [CustomersController::class, 'index']);
Route::get('/customers/{id}', [CustomersController::class, 'show']);
Route::post('/customers', [CustomersController::class, 'store']);
Route::delete('/customers/{id}', [CustomersController::class, 'destroy']);
Route::put('/customers/{id}', [CustomersController::class, 'update']);
Route::patch('/customers/{id}', [CustomersController::class, 'updatePartial']);

Route::get('/loans', [LoansController::class, 'index']);
Route::get('/loans/{id}', [LoansController::class, 'show']);
Route::post('/loans', [LoansController::class, 'store']);
Route::delete('/loans/{id}', [LoansController::class, 'destroy']);
Route::put('/loans/{id}', [LoansController::class, 'update']);

Route::get('/loans_status', [LoansStatusController::class, 'index']);
Route::get('/loans_status/{id}', [LoansStatusController::class, 'show']);
Route::post('/loans_status', [LoansStatusController::class, 'store']);
