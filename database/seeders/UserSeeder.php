<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
            'phone_number' => '912345678',
            'role_id' => 3,
        ]);
        User::factory()->create([
            'first_name' => 'Business',
            'last_name' => 'User',
            'email' => 'business@example.com',
            'password' => bcrypt('secret'),
            'phone_number' => '912345678',
            'role_id' => 2,
        ]);

        User::factory()->count(90)->create();
    }
}
