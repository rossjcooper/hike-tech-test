<?php

namespace App\Http\Controllers\Bookings;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookingConfirmedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Booking $booking): Response
    {
        return Inertia::render('Bookings/Confirmed', [
            'booking' => BookingResource::make($booking),
        ]);
    }
}
