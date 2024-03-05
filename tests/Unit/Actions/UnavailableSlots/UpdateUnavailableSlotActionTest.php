<?php

use App\Models\UnavailableSlot;

it('updates an unavailable slot', function () {
    $slot = UnavailableSlot::factory()->create();

    $startAt = now()->addDay();
    $endAt = now()->addDay()->addHour();

    $action = app(\App\Actions\UnavailableSlots\UpdateUnavailableSlotAction::class);

    $action->execute($slot, $startAt, $endAt);

    \Pest\Laravel\assertDatabaseHas('unavailable_slots', [
        'id' => $slot->id,
        'start_at' => $startAt,
        'end_at' => $endAt,
    ]);
});
