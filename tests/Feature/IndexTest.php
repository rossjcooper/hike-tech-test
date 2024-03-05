<?php

use App\Models\User;

it('redirects a guest to the booking form', function () {
    \Pest\Laravel\get(route('index'))
        ->assertRedirectToRoute('bookings.create');
});

it('redirects a user to the dashboard', function () {
    $user = User::factory()->create();

    \Pest\Laravel\actingAs($user)
        ->get(route('index'))
        ->assertRedirectToRoute('admin.bookings.index');
});
