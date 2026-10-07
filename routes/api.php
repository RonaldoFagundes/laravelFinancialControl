<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BankController;
use App\Http\Controllers\AccountController;


Route::get('/banks', [BankController::class, 'index']);
Route::get('/bank/{id}', [BankController::class, 'show']);

Route::post('/bank', [BankController::class, 'store']);

Route::put('/bank/{id}', [BankController::class, 'update']);
Route::delete('/bank/{id}', [BankController::class, 'destroy']);




Route::get('/accounts',[AccountController::class, 'index']);
Route::get('/accounts/{id}',[AccountController::class, 'show']);
Route::post('/accounts',[AccountController::class, 'store']);
Route::put('/accounts/{id}',[AccountController::class, 'update']);
Route::delete('/accounts/{id}',[AccountController::class, 'destroy']);
Route::get('/bank/{id}/accounts',[AccountController::class, 'byBank']);







use \App\Http\Controllers\EstaticPosts;
Route::get('/', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API funcionando!'
    ]);    
});

//Route::get('show',[EstaticPosts::class, 'showPosts']);
