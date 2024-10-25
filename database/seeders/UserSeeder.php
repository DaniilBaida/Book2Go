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
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
            'role_id' => 3,
        ]);
        User::factory()->create([
            'name' => 'Business Owner',
            'email' => 'business@example.com',
            'password' => bcrypt('secret'),
            'role_id' => 2,
        ]);

        User::factory()->count(90)->create();
    }
}
