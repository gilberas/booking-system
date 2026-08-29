<?php

namespace App\Notifications\Channels;

use App\Models\Notification as NotificationModel;
use Illuminate\Notifications\Notification;

class CustomDatabaseChannel
{
    public function send(object $notifiable, Notification $notification): ?NotificationModel
    {
        $data = method_exists($notification, 'toCustomDatabase')
            ? $notification->toCustomDatabase($notifiable)
            : $notification->toArray($notifiable);

        return $notifiable->customNotifications()->create([
            'type' => get_class($notification),
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->getKey(),
            'data' => json_encode($data),
            'read_at' => null,
        ]);
    }
}
