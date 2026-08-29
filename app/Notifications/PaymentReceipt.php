<?php

namespace App\Notifications;

use App\Models\Payment;
use App\Notifications\Channels\CustomDatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceipt extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Payment $payment
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', CustomDatabaseChannel::class];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $booking = $this->payment->booking;

        return (new MailMessage)
            ->subject("Payment Receipt — {$booking->booking_number}")
            ->greeting("Hi {$notifiable->name},")
            ->line('Your payment has been processed successfully.')
            ->line("Booking #: {$booking->booking_number}")
            ->line('Amount: $'.number_format($this->payment->amount, 2))
            ->line('Method: '.ucfirst(str_replace('_', ' ', $this->payment->payment_method)))
            ->line("Transaction: {$this->payment->transaction_id}")
            ->action('View Receipt', route('customer.payments.receipt', $booking))
            ->line('Thank you for your payment!');
    }

    public function toCustomDatabase(object $notifiable): array
    {
        $booking = $this->payment->booking;

        return [
            'title' => 'Payment Received',
            'body' => 'Payment of $'.number_format($this->payment->amount, 2)." for booking #{$booking->booking_number} received.",
            'url' => route('customer.payments.receipt', $booking),
            'icon' => 'credit-card',
            'type' => 'success',
        ];
    }
}
