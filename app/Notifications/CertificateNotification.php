<?php

namespace App\Notifications;

use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CertificateNotification extends Notification
{
    public function __construct(
        public Certificate $certificate,
        public Course $course
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Selamat! Sertifikat Kamu Sudah Siap')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Selamat! Kamu telah menyelesaikan course:')
            ->line('**' . $this->course->title . '**')
            ->line('Nomor Sertifikat: **' . $this->certificate->certificate_number . '**')
            ->line('Tanggal: ' . $this->certificate->issued_at->format('d F Y'))
            ->line('Simpan nomor sertifikat kamu untuk verifikasi.')
            ->salutation('Salam, ' . config('app.name'));
    }
}