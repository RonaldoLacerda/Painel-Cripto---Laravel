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

use App\Http\Controllers\CryptoController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/crypto', [CryptoController::class, 'index']);
Route::get('/cryptos', [CryptoController::class, 'getCryptos']);