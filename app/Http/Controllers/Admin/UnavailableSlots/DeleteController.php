<?php

namespace App\Http\Controllers\Admin\UnavailableSlots;

use App\Actions\UnavailableSlots\DeleteUnavailableSlotAction;
use App\Http\Controllers\Controller;
use App\Models\UnavailableSlot;
use Illuminate\Http\RedirectResponse;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UnavailableSlot $slot, DeleteUnavailableSlotAction $deleteUnavailableSlotAction): RedirectResponse
    {
        $deleteUnavailableSlotAction->execute($slot);

        return redirect()->route('admin.unavailable-slots.index');
    }
}
