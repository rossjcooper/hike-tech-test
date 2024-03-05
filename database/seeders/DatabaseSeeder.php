<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->create([
                'name' => 'Hayden',
                'email' => 'hayden@example.com',
                'password' => bcrypt('password'),
            ]);

        Booking::factory()
            ->count(10)
            ->create();
    }
}
