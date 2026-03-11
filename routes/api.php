<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function () {

    Route::get('/user', [AuthenticationController::class, 'profile']);
    Route::post('/logout', [AuthenticationController::class, 'logOut']);


    Route::post('/wallets', [WalletController::class, 'store']);
    Route::get('/wallets', [WalletController::class, 'index']);
    Route::get('/wallets/{id}', [WalletController::class, 'show']);

    Route::post('/wallets/{id}/deposit', [WalletController::class, 'deposit']);

    Route::post('/wallets/{id}/withdraw', [WalletController::class, 'withdraw']);

    Route::post('/wallets/{id}/transfer', [TransactionController::class, 'store']);

    Route::get('/wallets/{id}/transactions', [TransactionController::class, 'show']);
});



Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);



Route::get('/register', function () {
    return response()->json([
        'message' => 'enter'
    ]);
});
