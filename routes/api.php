<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\LoanStatusController;

Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::patch('/customers/{id}', [CustomerController::class, 'updatePartial']);

Route::get('/loans', [LoanController::class, 'index']);
Route::get('/loans/{id}', [LoanController::class, 'show']);
Route::post('/loans', [LoanController::class, 'store']);
Route::delete('/loans/{id}', [LoanController::class, 'destroy']);
Route::put('/loans/{id}', [LoanController::class, 'update']);

Route::get('/loan_status', [LoanStatusController::class, 'index']);
Route::get('/loan_status/{id}', [LoanStatusController::class, 'show']);
Route::post('/loan_status', [LoanStatusController::class, 'store']);
