<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CustomersController;

Route::get('/customers', [CustomersController::class, 'index']);
Route::get('/customers/{id}', [CustomersController::class, 'show']);
Route::post('/customers', [CustomersController::class, 'store']);
