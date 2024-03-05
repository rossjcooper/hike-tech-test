<?php

use App\Actions\UnavailableSlots\CreateUnavailableSlotAction;
use App\Models\UnavailableSlot;

it('creates a new unavailable slot', function () {
    $startAt = now();
    $endAt = now()->addHour();

    $action = app(CreateUnavailableSlotAction::class);

    $unavailableSlot = $action->execute($startAt, $endAt);

    expect($unavailableSlot)->toBeInstanceOf(UnavailableSlot::class);

    \Pest\Laravel\assertDatabaseHas('unavailable_slots', [
        'id' => $unavailableSlot->id,
        'start_at' => $startAt,
        'end_at' => $endAt,
    ]);
});
