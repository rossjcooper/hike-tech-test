<?php

use App\Actions\Bookings\CreateBookingAction;
use App\Models\Booking;
use App\Models\UnavailableSlot;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

use function Pest\Laravel\partialMock;
use function Pest\Laravel\post;

it('validates the request data', function (array $data, array $errors) {
    post(route('bookings.store'), $data)
        ->assertStatus(302)
        ->assertSessionHasErrors($errors);
})->with([
    [
        'data' => [],
        'errors' => [
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'phone' => 'The phone field is required.',
            'vehicleMake' => 'The vehicle make field is required.',
            'vehicleModel' => 'The vehicle model field is required.',
            'date' => 'The date field is required.',
        ],
    ],
    [
        'data' => [
            'name' => Str::random(256),
            'email' => Str::random(256).'@example.com',
            'phone' => Str::random(21),
            'vehicleMake' => Str::random(256),
            'vehicleModel' => Str::random(256),
        ],
        'errors' => [
            'name' => 'The name field must not be greater than 255 characters.',
            'email' => 'The email field must not be greater than 255 characters.',
            'phone' => 'The phone field must not be greater than 20 characters.',
            'vehicleMake' => 'The vehicle make field must not be greater than 255 characters.',
            'vehicleModel' => 'The vehicle model field must not be greater than 255 characters.',
        ],
    ],
    [
        'data' => [
            'email' => 'not-an-email',
            'date' => 'not-a-date',
        ],
        'errors' => [
            'email' => 'The email field must be a valid email address.',
            'date' => 'The date field must be a valid date.',
        ],
    ],
    [
        'data' => [
            'date' => now()->subDay()->format('Y-m-d'),
        ],
        'errors' => [
            'date' => 'The date field must be a date after now.',
        ],
    ],
]);

it('validates the date field based on opening hours', function () {
    post(route('bookings.store'), [
        'date' => now()->addWeek()->setDaysFromStartOfWeek(1)->setTime(23, 0), // Monday 11pm
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors([
            'date' => 'We are not open at this time.',
        ]);

    Pest\Laravel\post(route('bookings.store'), [
        'date' => now()->addWeek()->setDaysFromStartOfWeek(6)->setTime(10, 0), // Monday 11pm
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors([
            'date' => 'We are not open at this time.',
        ]);
});

it('doesnt allow double bookings', function () {
    $booking = Booking::factory()->create([
        'start_at' => now()->addWeek()->setDaysFromStartOfWeek(1)->setTime(10, 0),
        'end_at' => now()->addWeek()->setDaysFromStartOfWeek(1)->setTime(10, 30),
    ]);

    post(route('bookings.store'), [
        'date' => $booking->start_at,
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors([
            'date' => 'Not available at this time.',
        ]);

    post(route('bookings.store'), [
        'date' => $booking->start_at->subMinutes(15),
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors([
            'date' => 'Not available at this time.',
        ]);
});

it('doesnt allow booking during unavailable slot', function () {
    $slot = UnavailableSlot::factory()->create([
        'start_at' => now()->addWeek()->setDaysFromStartOfWeek(1)->setTime(10, 0), // Monday 10am
        'end_at' => now()->addWeek()->setDaysFromStartOfWeek(1)->setTime(12, 30), // Monday 12:30pm
    ]);

    post(route('bookings.store'), [
        'date' => $slot->start_at->clone(),
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors([
            'date' => 'Not available at this time.',
        ]);

    post(route('bookings.store'), [
        'date' => $slot->start_at->clone()->addMinutes(30),
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors([
            'date' => 'Not available at this time.',
        ]);

    post(route('bookings.store'), [
        'date' => $slot->start_at->clone()->setTime(9, 45),
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors([
            'date' => 'Not available at this time.',
        ]);

    post(route('bookings.store'), [
        'date' => $slot->start_at->clone()->setTime(12, 30),
    ])
        ->assertStatus(302)
        ->assertSessionHasErrors([
            'date' => 'Not available at this time.',
        ]);
});

it('allows user to create a new booking', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'vehicleMake' => 'Toyota',
        'vehicleModel' => 'Corolla',
        'date' => now()->addWeek()->setDaysFromStartOfWeek(1)->setTime(10, 0)->toIso8601String(),
    ];

    $booking = Booking::factory()->create();

    partialMock(CreateBookingAction::class)
        ->shouldReceive('execute')
        ->once()
        ->withArgs(function ($name, $email, $phone, $vehicleMake, $vehicleModel, $startAt) use ($data) {
            expect($name)->toBe($data['name'])
                ->and($email)->toBe($data['email'])
                ->and($phone)->toBe($data['phone'])
                ->and($vehicleMake)->toBe($data['vehicleMake'])
                ->and($vehicleModel)->toBe($data['vehicleModel'])
                ->and($startAt)->toBeInstanceOf(CarbonInterface::class)
                ->and($startAt->toIso8601String())->toBe($data['date']);

            return true;
        })
        ->andReturn($booking);

    post(route('bookings.store'), $data)
        ->assertRedirect(Url::signedRoute('bookings.confirmed', [$booking]));
});
