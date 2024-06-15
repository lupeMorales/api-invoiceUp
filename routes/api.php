<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicesController;

/* Route::prefix("v1")->group(function () {
    Route::resource('invoices', InvoicesController::class);
    Route::post('invoices/{id}', [InvoicesController::class, 'update']);
    Route::delete('invoices/{id}', [InvoicesController::class . 'destroy']);
}); */

Route::get('/invoices', [InvoicesController::class, 'index']);

Route::delete('invoices/{number_invoice}', [InvoicesController::class, 'destroy']);

Route::post('/invoices', [InvoicesController::class, 'store']);
Route::post('register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
