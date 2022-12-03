<?php

use App\Http\Controllers\api\Auth\UserController;
use App\Http\Controllers\api\Cart\CartController;
use App\Http\Controllers\api\Complain\ComplainController;
use App\Http\Controllers\api\CreateCartConTroller;
use App\Http\Controllers\api\ExtensionController;
use App\Http\Controllers\api\Log\AppLogController;
use App\Http\Controllers\api\Order\OrderController;
use App\Http\Controllers\api\Transaction\TransactionController;
use App\Http\Controllers\TestController;
use App\Http\GenerateCodeOrder\GenerateCode;
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
Route::post('/register', [UserController::class, 'getRegister']);

Route::post('/user/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('/user/reset-password/{token}', [UserController::class, 'resetPassword']);

// protected api
Route::middleware('auth:api,web')->group(function () 
{

    Route::get('/user', [UserController::class, 'getUserInfo']);
    Route::put('/update-user', [UserController::class, 'UpdateUser']);
    Route::post('/user/new-address', [UserController::class, 'newAddress']);
    
    Route::get('/logs', [AppLogController::class, 'getLog']);
    //Đơn hàng
    Route::prefix('order')->group(function () {

        Route::get('get-order', [OrderController::class, 'getOrder']);

        Route::post('get-filter-order', [OrderController::class, 'getFilterOrder']);

        Route::post('create-order', [OrderController::class, 'createOrder']);

        Route::get('order-detail/{id}', [OrderController::class, 'orderDetail']);

        Route::post('order-info', [OrderController::class, 'orderInfoes']);

        Route::post('history-detail', [OrderController::class, 'historyDetail']);
    });
    //khiếu nại
    Route::get("get-complain",[ComplainController::class,"getComplain"]);


    //Thông báo
    Route::prefix('transaction')->group(function () {
        Route::post('create',[TransactionController::class,'createTransaction']);
        Route::get('type-transaction',[TransactionController::class,'getTypeTransaction']);
        Route::get('type-payment',[TransactionController::class,'getTypePayment']);
        Route::get('get-transaction', [TransactionController::class, 'getTransaction']);
        Route::get('generateCode',[GenerateCode::class,'generateCodeTransaction']);
        Route::get("fetchTransaction",[TransactionController::class,'fetchTransaction']);
    });
    Route::prefix('cart')->group(function () {
        Route::get('list', [CartController::class, 'getCart']);
        Route::post('create', [CartController::class, 'cartCreate']);
    });
    Route::delete("cart-product/{id}", [CartController::class, 'removeProduct']);
    Route::post("cart-deleteAll",[CartController::class,'deleteAllCart']);
    Route::post("cart-checkout", [CartController::class, "cartCheckout"]);
    Route::post("cart-checkoutByProduct",[CartController::class,"cartCheckByProduct"]);
    Route::get("get-address/{id}",[CartController::class,'getAddressUser']);
});
