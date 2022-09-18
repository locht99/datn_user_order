<?php

use App\Http\Controllers\api\Auth\UserController;
use App\Http\Controllers\api\CreateCartConTroller;
use App\Http\Controllers\api\ExtensionController;
use App\Http\Controllers\api\Order\OrderController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/extension-login', [ExtensionController::class, 'login']);
Route::post('/create-cart', [ExtensionController::class, 'createCart']);
Route::get('/get-exchange-rate', [ExtensionController::class, 'getExchangeRate']);
Route::get('/test', [TestController::class, 'index']);

///////////////
//public api
Route::post('/login', [UserController::class, 'getLogin']);
// protected api
Route::middleware('auth:api')->group(function () {
    Route::prefix('order')->group(function () {
        Route::get('getOrder', [OrderController::class, 'getOrder']);
    });
});
