<?php

it('doesnt allow unauthenticated users to view bookings', function () {
    \Pest\Laravel\get(route('admin.bookings.index'))
        ->assertRedirect(route('login'));
});

it('allows user to see future bookings', function () {
    $user = \App\Models\User::factory()->create();

    $futureBookings = \App\Models\Booking::factory()->count(3)->create();

    $pastBooking = \App\Models\Booking::factory()->create([
        'start_at' => now()->subDay(),
        'end_at' => now()->subDay()->add(config('app.booking_length')),
    ]);

    \Pest\Laravel\actingAs($user)
        ->get(route('admin.bookings.index'))
        ->assertOk()
        ->assertInertia(fn (\Inertia\Testing\AssertableInertia $page) => $page
            ->component('Admin/Bookings/Index')
            ->has('bookings.data', 3)
            ->where('bookings.data', function ($bookings) use ($futureBookings) {
                expect($futureBookings->sortBy('start_at')->pluck('id')->toArray())->toEqual($bookings->pluck('id')->toArray());

                return true;
            })
        );
});

it('allows user to see bookings on a specific date', function () {
    $user = \App\Models\User::factory()->create();

    $otherBookings = \App\Models\Booking::factory()->count(3)->create();

    $pastBooking = \App\Models\Booking::factory()->create([
        'start_at' => now()->subDay(),
        'end_at' => now()->subDay()->add(config('app.booking_length')),
    ]);

    $date = $pastBooking->start_at->format('Y-m-d');

    \Pest\Laravel\actingAs($user)
        ->get(route('admin.bookings.index', ['date' => $date]))
        ->assertOk()
        ->assertInertia(fn (\Inertia\Testing\AssertableInertia $page) => $page
            ->component('Admin/Bookings/Index')
            ->has('bookings.data', 1)
            ->where('bookings.data', function ($bookings) use ($pastBooking) {
                expect($pastBooking->id)->toEqual($bookings->first()['id']);

                return true;
            })
        );
});
