<?php

namespace App\Notifications;

use App\Models\Course;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EnrollmentNotification extends Notification
{
    public function __construct(public Course $course) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pendaftaran Course Berhasil!')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kamu berhasil mendaftar di course berikut:')
            ->line('**' . $this->course->title . '**')
            ->line('Kategori: ' . $this->course->category)
            ->line('Level: ' . $this->course->level)
            ->line('Selamat belajar dan semangat!')
            ->salutation('Salam, ' . config('app.name'));
    }
}