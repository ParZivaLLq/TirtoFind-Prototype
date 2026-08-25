<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Klaim TirtoFind berhasil diterima')
            ->greeting('Pengajuan klaim diterima')
            ->line("Kode klaim: {$notifiable->claim_code}")
            ->line('Simpan kode tersebut untuk memantau status klaim Anda.')
            ->action('Lacak klaim', route('claim.tracking', ['claim_code' => $notifiable->claim_code]));
    }
}
