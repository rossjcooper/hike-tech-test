<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/bookings', Admin\Bookings\IndexController::class)->name('bookings.index');

    Route::get('/unavailable-slots', Admin\UnavailableSlots\IndexController::class)->name('unavailable-slots.index');
    Route::get('/unavailable-slots/create', Admin\UnavailableSlots\CreateController::class)->name('unavailable-slots.create');
    Route::post('/unavailable-slots', Admin\UnavailableSlots\StoreController::class)->name('unavailable-slots.store');
    Route::get('/unavailable-slots/{slot}', Admin\UnavailableSlots\EditController::class)->name('unavailable-slots.edit');
    Route::put('/unavailable-slots/{slot}', Admin\UnavailableSlots\UpdateController::class)->name('unavailable-slots.update');
    Route::delete('/unavailable-slots/{slot}', Admin\UnavailableSlots\DeleteController::class)->name('unavailable-slots.delete');
});
