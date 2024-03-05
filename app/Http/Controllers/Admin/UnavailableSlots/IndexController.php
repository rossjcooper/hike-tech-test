<?php

namespace App\Http\Controllers\Admin\UnavailableSlots;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UnavailableSlotResource;
use App\Models\UnavailableSlot;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        $slots = UnavailableSlot::query()
            ->where('end_at', '>=', now())
            ->oldest('start_at')
            ->get();

        return Inertia::render('Admin/UnavailableSlots/Index', [
            'slots' => UnavailableSlotResource::collection($slots),
        ]);
    }
}
