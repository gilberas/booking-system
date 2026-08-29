<?php

namespace App\Notifications;

use Carbon\CarbonInterface;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpNotification extends Notification
{
    public function __construct(
        private readonly string $otp,
        private readonly CarbonInterface $expiresAt,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * The raw OTP value. Only used by tests and by the mail renderer —
     * never persisted or logged by the application.
     */
    public function otp(): string
    {
        return $this->otp;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $minutes = max(1, (int) now()->diffInMinutes($this->expiresAt));

        return (new MailMessage)
            ->subject('Your '.config('app.name').' login verification code')
            ->greeting('Hello '.$notifiable->name.'!')
            ->line('You requested to sign in to your '.config('app.name').' account.')
            ->line('Your verification code is:')
            ->line('**'.$this->otp.'**')
            ->line("This code will expire in {$minutes} minute(s).")
            ->line('If you did not attempt to sign in, you can safely ignore this email.');
    }
}
