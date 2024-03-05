<?php

use Illuminate\Foundation\Application;
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

Route::get('/', \App\Http\Controllers\IndexController::class)->name('index');

Route::get('/book', \App\Http\Controllers\Bookings\CreateBookingController::class)->name('bookings.create');
Route::post('/book', \App\Http\Controllers\Bookings\StoreBookingController::class)->name('bookings.store');
Route::get('/booking/{booking}/confirmed', \App\Http\Controllers\Bookings\BookingConfirmedController::class)
    ->middleware(['signed'])
    ->name('bookings.confirmed');
