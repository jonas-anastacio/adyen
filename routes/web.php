<?php

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

Route::get('/', function () {
    return view('checkout');
});

Route::get('/classic', function() {
    return view('classic');
});

Route::get('/classic_recurring', function() {
    return view('classic_recurring');
});

Route::get('/classic_boleto', function() {
    return view('classic_boleto');
});