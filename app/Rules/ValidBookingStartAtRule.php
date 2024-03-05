<?php

namespace App\Rules;

use App\Models\Booking;
use App\Models\UnavailableSlot;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class ValidBookingStartAtRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $startAt = Carbon::parse($value);
        $endAt = $startAt->copy()->add(config('app.booking_length'));

        $bookingExists = Booking::query()
            ->whereBetween('start_at', [$startAt, $endAt])
            ->orWhereBetween('end_at', [$startAt, $endAt])
            ->orWhereRaw('? BETWEEN start_at and end_at', [$startAt])
            ->orWhereRaw('? BETWEEN start_at and end_at', [$endAt])
            ->exists();

        if ($bookingExists) {
            $fail('Not available at this time.');

            return;
        }

        $dayOfWeek = strtolower($startAt->format('l'));

        $openingHours = config("app.opening_hours.$dayOfWeek");

        $outOfHoursMessage = 'We are not open at this time.';

        if ($openingHours === null) {
            $fail($outOfHoursMessage);

            return;
        }

        $openAt = $startAt->clone()->setTimeFromTimeString($openingHours['open']);
        $closeAt = $startAt->clone()->setTimeFromTimeString($openingHours['close']);

        if ($startAt->lt($openAt) || $endAt->gte($closeAt)) {
            $fail($outOfHoursMessage);

            return;
        }

        $isUnavailableSlot = UnavailableSlot::query()
            ->whereBetween('start_at', [$startAt, $endAt])
            ->orWhereBetween('end_at', [$startAt, $endAt])
            ->orWhereRaw('? BETWEEN start_at and end_at', [$startAt])
            ->orWhereRaw('? BETWEEN start_at and end_at', [$endAt])
            ->exists();

        if ($isUnavailableSlot) {
            $fail('Not available at this time.');
        }
    }
}
