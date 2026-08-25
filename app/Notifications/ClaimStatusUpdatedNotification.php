<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Pembaruan status klaim {$notifiable->claim_code}")
            ->greeting('Status klaim diperbarui')
            ->line("Status terbaru: {$notifiable->status}")
            ->action('Lihat status klaim', route('claim.tracking', ['claim_code' => $notifiable->claim_code]));
    }
}
