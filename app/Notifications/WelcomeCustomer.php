<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomDatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeCustomer extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct() {}

    public function via(object $notifiable): array
    {
        return ['mail', CustomDatabaseChannel::class];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to '.config('app.name'))
            ->greeting("Welcome {$notifiable->name}!")
            ->line('Thank you for registering with us.')
            ->line('You can now search for rooms, make bookings, and manage your reservations.')
            ->action('Search Rooms', route('search'))
            ->line('We look forward to serving you!');
    }

    public function toCustomDatabase(object $notifiable): array
    {
        return [
            'title' => 'Welcome',
            'body' => 'Welcome to '.config('app.name').'! Start searching for rooms and booking your stay.',
            'url' => route('search'),
            'icon' => 'star',
            'type' => 'success',
        ];
    }
}
