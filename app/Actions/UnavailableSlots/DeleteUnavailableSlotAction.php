<?php

namespace App\Actions\UnavailableSlots;

use App\Models\UnavailableSlot;

class DeleteUnavailableSlotAction
{
    public function execute(
        UnavailableSlot $slot,
    ): void {
        $slot->delete();
    }
}
