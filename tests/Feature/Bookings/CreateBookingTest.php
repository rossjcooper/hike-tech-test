<?php

it('shows the create booking screen', function () {
    \Pest\Laravel\get(route('bookings.create'))
        ->assertStatus(200)
        ->assertInertia(fn (\Inertia\Testing\AssertableInertia $assert) => $assert
            ->component('Bookings/Create')
        );
});
