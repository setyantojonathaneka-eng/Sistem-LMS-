<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'student')->get();

        if ($users->isEmpty()) {
            $this->command->info('Tidak ada user student. Lewati seeder notification.');
            return;
        }

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title'   => 'Selamat datang di LearnPath! 🎉',
                'body'    => 'Mulai perjalanan belajar Anda dengan menjelajahi course yang tersedia.',
                'color'   => '#5D9EC7',
                'type'    => 'welcome',
            ]);
        }

        $this->command->info('Notifikasi selamat datang berhasil dibuat untuk ' . $users->count() . ' student.');
    }
}
