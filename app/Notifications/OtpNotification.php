<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OtpNotification extends Notification
{
    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Kode Verifikasi OTP')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Gunakan kode OTP berikut untuk verifikasi email kamu:')
            ->line('**' . $this->otp . '**')
            ->line('Kode ini berlaku selama 10 menit.')
            ->line('Jika kamu tidak merasa mendaftar, abaikan email ini.');
    }
}