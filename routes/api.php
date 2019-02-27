<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('checkout')->group(function() {
    Route::post('methods', 'Checkout@paymentMethods');
    Route::post('pay/boleto', 'Checkout@boletoPayment');
    Route::post('pay/credit', 'Checkout@creditCardPayment')->name('pay.credit');
    Route::prefix('classic')->group(function() {
        Route::post('pay/boleto', 'ClassicCheckout@getBoleto')->name('classic.boleto');
        Route::post('pay/credit', 'ClassicCheckout@authorizePurchase')->name('classic.credit');
        Route::post('cancel', 'ClassicCheckout@cancelPurchase')->name('classic.cancel');
    });
});
