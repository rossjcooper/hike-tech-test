<?php

use App\Models\UnavailableSlot;

it('deletes an unavailable slot', function () {
    $slot = UnavailableSlot::factory()->create();

    $action = app(\App\Actions\UnavailableSlots\DeleteUnavailableSlotAction::class);

    $action->execute($slot);

    \Pest\Laravel\assertDatabaseMissing('unavailable_slots', [
        'id' => $slot->id,
    ]);
});
