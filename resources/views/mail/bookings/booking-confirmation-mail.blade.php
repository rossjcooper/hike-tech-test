<x-mail::message>
# Booking Confirmation

Thank you for booking with us. Your booking details are as follows:

- Booking ID: {{ $booking->getRouteKey() }}
- Name: {{ $booking->name }}
- Email: {{ $booking->email }}
- Phone: {{ $booking->phone }}
- Date: {{ $booking->start_at->format('d M Y H:m a') }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
