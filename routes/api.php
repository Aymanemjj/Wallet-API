<?php

use App\Http\Controllers\Api\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function(){

Route::post('/logout', [AuthenticationController::class, 'logOut']);

});



Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);



Route::get('/register', function(){
    return response()->json([
        'message'=>'enter'
    ]);
});