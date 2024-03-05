<?php

namespace App\Http\Controllers\Admin\UnavailableSlots;

use App\Actions\UnavailableSlots\CreateUnavailableSlotAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnavailableSlots\StoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRequest $request, CreateUnavailableSlotAction $createUnavailableSlotAction): RedirectResponse
    {
        $createUnavailableSlotAction->execute(
            $request->date('startAt'),
            $request->date('endAt')
        );

        return redirect()->route('admin.unavailable-slots.index');
    }
}
