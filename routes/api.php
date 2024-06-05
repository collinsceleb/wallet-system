<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('wallet/credit', [WalletController::class, 'credit']);
    Route::post('wallet/debit', [WalletController::class, 'debit']);
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('guest')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
});
