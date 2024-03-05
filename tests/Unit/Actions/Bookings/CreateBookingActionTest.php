<?php

use App\Actions\Bookings\CreateBookingAction;
use App\Mail\Bookings\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\Bookings\BookingCreatedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\assertDatabaseHas;

it('creates a new booking and sends notifications', function () {
    Notification::fake();
    Mail::fake();

    $user = User::factory()->create();

    $action = app(CreateBookingAction::class);

    $name = fake()->name;
    $email = fake()->email;
    $phone = fake()->phoneNumber;
    $vehicleMake = 'Tesla';
    $vehicleModel = 'Model Y';
    $startAt = Carbon::now()->addDay()->setTime(10, 0);

    $booking = $action->execute(
        $name,
        $email,
        $phone,
        $vehicleMake,
        $vehicleModel,
        $startAt,
    );

    expect($booking)->toBeInstanceOf(Booking::class);

    assertDatabaseHas('bookings', [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'vehicle_make' => $vehicleMake,
        'vehicle_model' => $vehicleModel,
        'start_at' => $startAt->toDateTimeString(),
        'end_at' => $startAt->add(config('app.booking_length'))->toDateTimeString(),
    ]);

    Notification::assertSentTo($user, BookingCreatedNotification::class);

    Mail::assertSent(BookingConfirmationMail::class, function ($mail) use ($booking) {
        return $mail->hasTo($booking->email);
    });
});
