<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\ShortLinkController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout',[AuthController::class,'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // pour le logout
    Route::get('/modules', [ModuleController::class, 'index']);
    Route::post('/modules/{id}/activate', [ModuleController::class, 'activate']);
    Route::post('/modules/{id}/deactivate', [ModuleController::class, 'deactivate']);

});

//POur lautehentifiaction
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/shorten', [ShortLinkController::class, 'store']);
//     Route::get('/s/{code}', [ShortLinkController::class, 'redirect']);
//     Route::get('/links', [ShortLinkController::class, 'index']);
//     Route::delete('/links/{id}', [ShortLinkController::class, 'destroy']);
// });

Route::get('/s/{code}', [ShortLinkController::class, 'redirect']);

Route::middleware(['auth:sanctum', 'check.module.active:1'])->group(function () {
    Route::post('/shorten', [ShortLinkController::class, 'store']);
    Route::get('/links', [ShortLinkController::class, 'index']);
    Route::delete('/links/{id}', [ShortLinkController::class, 'destroy']);

});

Route::middleware(['auth:sanctum', 'check.module.active:2'])->group(function () {

Route::get('/wallet', [WalletController::class, 'show']);
Route::post('/wallet/topup', [WalletController::class, 'topUp']);
Route::get('/wallet/transactions', [WalletController::class, 'transactions']);
Route::post('/wallet/transfer', [TransactionController::class, 'transfer']);
});