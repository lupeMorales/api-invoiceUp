<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicesController;

Route::prefix("v1")->group(function () {
    Route::resource('invoices', InvoicesController::class);
    Route::post('invoices/{id}', [InvoicesController::class, 'update']);
    Route::delete('invoices/{id}', [InvoicesController::class . 'destroy']);
});

Route::prefix("v1")->group(function () {

    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
