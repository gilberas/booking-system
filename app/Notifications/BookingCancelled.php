<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Notifications\Channels\CustomDatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelled extends Notification implements ShouldQueue
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
        $mail = (new MailMessage)
            ->subject("Booking Cancelled — {$this->booking->booking_number}")
            ->greeting("Hi {$notifiable->name},")
            ->line("Your booking at **{$this->booking->hotel->name}** has been cancelled.")
            ->line("Booking #: {$this->booking->booking_number}")
            ->line("Reason: {$this->booking->cancellation_reason}");

        if (($this->booking->refund_percentage ?? 0) > 0) {
            $mail->line("Refund: {$this->booking->refund_percentage}% (\$".number_format($this->booking->refund_amount ?? 0, 2).')');
        }

        return $mail
            ->action('View Details', route('customer.bookings.show', $this->booking))
            ->line('If you have questions, please contact support.');
    }

    public function toCustomDatabase(object $notifiable): array
    {
        return [
            'title' => 'Booking Cancelled',
            'body' => "Your booking #{$this->booking->booking_number} at {$this->booking->hotel->name} has been cancelled.",
            'url' => route('customer.bookings.show', $this->booking),
            'icon' => 'x-circle',
            'type' => 'danger',
        ];
    }
}
