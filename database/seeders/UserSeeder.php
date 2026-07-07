<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'              => 'Admin',
            'email'             => 'admin@learnpath.com',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'is_verified'       => true,
            'email_verified_at' => now(),
        ]);

        // Instructors
        User::create([
            'name'              => 'Budi Santoso',
            'email'             => 'budi.s@learnpath.com',
            'password'          => Hash::make('password'),
            'role'              => 'instructor',
            'is_verified'       => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Diana Rahayu',
            'email'             => 'diana.r@learnpath.com',
            'password'          => Hash::make('password'),
            'role'              => 'instructor',
            'is_verified'       => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Rina Kusuma',
            'email'             => 'rina.k@learnpath.com',
            'password'          => Hash::make('password'),
            'role'              => 'instructor',
            'is_verified'       => true,
            'email_verified_at' => now(),
        ]);

        // Students
        $students = [
            ['name' => 'Andi Nugroho',  'email' => 'andi@email.com'],
            ['name' => 'Siti Rahayu',   'email' => 'siti@email.com'],
            ['name' => 'Budi Wijaya',   'email' => 'budiwi@email.com'],
            ['name' => 'Diana Lestari', 'email' => 'diana@email.com'],
            ['name' => 'Maya Fitri',    'email' => 'maya@email.com'],
            ['name' => 'Rudi Hartono',  'email' => 'rudi@email.com'],
        ];

        foreach ($students as $student) {
            User::create([
                'name'              => $student['name'],
                'email'             => $student['email'],
                'password'          => Hash::make('password'),
                'role'              => 'student',
                'is_verified'       => true,
                'email_verified_at' => now(),
            ]);
        }
    }
}