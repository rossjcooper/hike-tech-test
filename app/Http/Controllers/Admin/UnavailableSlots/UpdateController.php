<?php

namespace App\Http\Controllers\Admin\UnavailableSlots;

use App\Actions\UnavailableSlots\UpdateUnavailableSlotAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnavailableSlots\StoreRequest;
use App\Models\UnavailableSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UnavailableSlot $slot, StoreRequest $request, UpdateUnavailableSlotAction $updateUnavailableSlotAction): RedirectResponse
    {
        $updateUnavailableSlotAction->execute(
            $slot,
            $request->date('startAt'),
            $request->date('endAt')
        );

        return redirect()->route('admin.unavailable-slots.index');
    }
}
