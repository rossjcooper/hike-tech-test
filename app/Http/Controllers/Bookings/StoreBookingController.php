<?php

namespace App\Http\Controllers\Bookings;

use App\Actions\Bookings\CreateBookingAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bookings\StoreBookingRequest;
use Illuminate\Http\RedirectResponse;

class StoreBookingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreBookingRequest $request, CreateBookingAction $createBookingAction): RedirectResponse
    {
        $booking = $createBookingAction->execute(
            $request->string('name'),
            $request->string('email'),
            $request->string('phone'),
            $request->string('vehicleMake'),
            $request->string('vehicleModel'),
            $request->date('date'),
        );

        return redirect()->signedRoute('bookings.confirmed', [$booking]);
    }
}
