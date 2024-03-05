<?php

namespace App\Notifications\Bookings;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Booking $booking,
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Booking Created')
            ->greeting("Hello $notifiable->name, a new booking has been created.")
            ->line("Name: {$this->booking->name}")
            ->line("Email: {$this->booking->email}")
            ->line("Phone: {$this->booking->phone}")
            ->line("Vehicle Make: {$this->booking->vehicle_make}")
            ->line("Vehicle Model: {$this->booking->vehicle_model}")
            ->line("Start At: {$this->booking->start_at->format('Y-m-d H:i')}");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
