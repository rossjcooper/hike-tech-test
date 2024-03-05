<?php

namespace App\Http\Controllers\Admin\UnavailableSlots;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UnavailableSlotResource;
use App\Models\UnavailableSlot;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UnavailableSlot $slot): Response
    {
        return Inertia::render('Admin/UnavailableSlots/Edit', [
            'slot' => UnavailableSlotResource::make($slot),
        ]);
    }
}
