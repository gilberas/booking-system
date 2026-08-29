<?php

namespace App\Notifications\Channels;

use App\Notifications\Messages\SmsMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SmsChannel
{
    public function send(object $notifiable, Notification $notification): void
    {
        $message = $notification->toSms($notifiable);

        if (! $message instanceof SmsMessage) {
            return;
        }

        $phone = $notifiable->routeNotificationFor('sms', $notification)
            ?? $notifiable->phone
            ?? null;

        if (! $phone) {
            Log::warning('SMS not sent: no phone number for notifiable', [
                'notifiable_id' => $notifiable->getKey(),
            ]);

            return;
        }

        Log::info('SMS would be sent', [
            'to' => $phone,
            'from' => $message->from,
            'body' => $message->body,
        ]);

        // Integration point: replace with actual SMS provider call.
        //
        // Example using Twilio:
        //   $twilio = new \Twilio\Rest\Client(
        //       config('services.twilio.sid'),
        //       config('services.twilio.token')
        //   );
        //   $twilio->messages->create($phone, [
        //       'from' => $message->from ?: config('services.twilio.from'),
        //       'body' => $message->body,
        //   ]);
        //
        // Required credentials (add to config/services.php and .env):
        //   TWILIO_SID=your_account_sid
        //   TWILIO_TOKEN=your_auth_token
        //   TWILIO_FROM=+1xxxxxxxxxx
        //
        // Alternative providers: Vonage (Nexmo), AWS SNS, Plivo, MessageBird.
        // Each requires their own SDK and credentials (API key, secret, sender ID).
    }
}
