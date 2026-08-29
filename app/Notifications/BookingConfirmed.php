<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Notifications\Channels\CustomDatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Booking $booking
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', CustomDatabaseChannel::class];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Booking Confirmed — {$this->booking->booking_number}")
            ->greeting("Hi {$notifiable->name},")
            ->line("Your booking at **{$this->booking->hotel->name}** is confirmed.")
            ->line("Booking #: {$this->booking->booking_number}")
            ->line("Check-in: {$this->booking->check_in->format('M d, Y')}")
            ->line("Check-out: {$this->booking->check_out->format('M d, Y')}")
            ->line('Total: $'.number_format($this->booking->total_amount, 2))
            ->action('View Booking', route('customer.bookings.show', $this->booking))
            ->line('Thank you for choosing our service!');
    }

    public function toCustomDatabase(object $notifiable): array
    {
        return [
            'title' => 'Booking Confirmed',
            'body' => "Your booking #{$this->booking->booking_number} at {$this->booking->hotel->name} is confirmed.",
            'url' => route('customer.bookings.show', $this->booking),
            'icon' => 'check-circle',
            'type' => 'success',
        ];
    }
}
