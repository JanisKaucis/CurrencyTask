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
Route::permanentRedirect('/', '/currency-exchange-rates')->name('home');

/*
|--------------------------------------------------------------------------
| Routes for currencies
|--------------------------------------------------------------------------
*/
Route::get('/currency-exchange-rates', [CurrenciesController::class, 'index'])->name('currencies.index');
Route::get('/currencies-today', [CurrenciesDataController::class, 'getTodayCurrencies'])->name('currencies.today');
Route::get('/all-currencies-', [CurrenciesDataController::class, 'getAllCurrencies'])->name('currencies.all');
Route::get('/dates-with-currencies', [CurrenciesDataController::class, 'getCurrencyDatesExchangeRates'])->name('currencies.dates');
Route::get('/filter-currencies', [CurrenciesDataController::class, 'filterCurrencies'])->name('currencies.filter');
