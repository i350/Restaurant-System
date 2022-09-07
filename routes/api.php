<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController as AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth Routes
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Customer Routes
Route::middleware(['auth:sanctum', 'customer'])->group(function () {
    Route::apiResource('orders', OrderController::class)->only(['store', 'index', 'show']);
});
