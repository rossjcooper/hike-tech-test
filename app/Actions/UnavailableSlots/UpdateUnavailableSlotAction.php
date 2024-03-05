<?php

namespace App\Actions\UnavailableSlots;

use App\Models\UnavailableSlot;
use Carbon\CarbonInterface;

class UpdateUnavailableSlotAction
{
    public function execute(
        UnavailableSlot $slot,
        CarbonInterface $startAt,
        CarbonInterface $endAt
    ): void {
        $slot->update([
            'start_at' => $startAt,
            'end_at' => $endAt,
        ]);
    }
}
