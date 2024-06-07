<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\WalletController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wallet', function () {
        $user = App\Models\User::find(Auth::id());
        $user->load('wallet');
        return Inertia::render('Wallet', [
            'user' => $user
        ]);
    });
    Route::post('wallet/credit', [WalletController::class, 'credit']);
    Route::post('wallet/debit', [WalletController::class, 'debit']);
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('guest')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
});
