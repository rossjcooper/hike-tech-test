<?php

namespace App\Actions\UnavailableSlots;

use App\Models\UnavailableSlot;
use Carbon\CarbonInterface;

class CreateUnavailableSlotAction
{
    public function execute(
        CarbonInterface $startAt,
        CarbonInterface $endAt
    ): UnavailableSlot {
        return UnavailableSlot::query()
            ->create([
                'start_at' => $startAt,
                'end_at' => $endAt,
            ]);
    }
}
