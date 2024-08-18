<?php

use App\Http\Controllers\Currencies\CurrenciesController;
use App\Http\Controllers\Currencies\CurrenciesDataController;
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
/*
|--------------------------------------------------------------------------
| Public routes without middlewares
|--------------------------------------------------------------------------
*/
Route::get('/', [CurrenciesController::class, 'index'])->name('currencies.index');
/*
|--------------------------------------------------------------------------
| Routes for currencies
|--------------------------------------------------------------------------
*/
Route::get('/popup-test', [CurrenciesDataController::class, 'getPopupText'])->name('currencies.popup');
