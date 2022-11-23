<?php

use App\Http\Controllers\api\Transaction\TransactionController;
use App\Http\Controllers\TestController;
use App\Http\Transaction\Transaction;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/getUser', [TestController::class, 'index'])->middleware();
Route::post('/getRequest',[TransactionController::class,'sendTransaction'])->name('getRequest');
Route::get('/getRequest',[TransactionController::class,'sendTransaction'])->name('getRequest');
Route::get('/{any}', function () {
    return view('index');
})->where('any', '^(?!api).*$');
