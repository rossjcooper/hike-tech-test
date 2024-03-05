<?php

namespace App\Http\Controllers\Admin\Bookings;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BookingResource;
use App\Models\Booking;
use Carbon\Exceptions\InvalidFormatException;
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
        $date = null;
        try {
            $date = $request->has('date') ? $request->date('date') : null;
        } catch (InvalidFormatException $e) {
            // Do nothing
        }

        $bookings = Booking::query()
            ->oldest('start_at')
            ->when($date, function ($query, $date) {
                $query->whereBetween('start_at', [
                    $date->clone()->startOfDay(),
                    $date->clone()->endOfDay(),
                ]);
            })
            ->when(! $date, function ($query) {
                $query->whereDate('start_at', '>=', now());
            })
            ->get();

        return Inertia::render('Admin/Bookings/Index', [
            'bookings' => BookingResource::collection($bookings),
            'date' => $request->string('date'),
        ]);
    }
}
