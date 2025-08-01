<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/customer', [StoreController::class, 'index']);
Route::post('/customer', [StoreController::class, 'store']);
Route::get('/customer/{id}', [StoreController::class, 'show']);
Route::patch('/customer/{id}', [StoreController::class, 'update']);
Route::delete('/customer/{id}', [StoreController::class, 'destroy']);
Route::post('/address', [AddressController::class, 'store']);
Route::patch('/address/{id}', [AddressController::class, 'update']);
Route::delete('/address/{id}', [AddressController::class, 'destroy']);
