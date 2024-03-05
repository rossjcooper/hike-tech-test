<?php

namespace App\Actions\Bookings;

use App\Mail\Bookings\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\Bookings\BookingCreatedNotification;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class CreateBookingAction
{
    public function execute(
        string $name,
        string $email,
        string $phone,
        string $vehicleMake,
        string $vehicleModel,
        CarbonInterface $startAt,
    ): Booking {
        $booking = Booking::query()->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'vehicle_make' => $vehicleMake,
            'vehicle_model' => $vehicleModel,
            'start_at' => $startAt,
            'end_at' => $startAt->clone()->add(config('app.booking_length')),
        ]);

        Notification::send(User::all(), new BookingCreatedNotification($booking));

        Mail::to($booking->email)->send(new BookingConfirmationMail($booking));

        return $booking;
    }
}
