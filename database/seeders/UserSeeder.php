<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '912345678',
            'role_id' => 3,
        ]);
        // Create Business User and associated Business
        $businessUser = User::factory()->create([
            'first_name' => 'Business',
            'last_name' => 'User',
            'email' => 'business@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '912345678',
            'role_id' => 2,
        ]);

        Business::factory()->create([
            'user_id' => $businessUser->id,
            'name' => $businessUser->first_name . "'s Business",
        ]);

        // Create Client User without Business
        User::factory()->create([
            'first_name' => 'Normal',
            'last_name' => 'User',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '912345678',
            'role_id' => 1, // Assuming role_id 1 is for Normal User
        ]);


        // Create 4 Regular Users with associated Businesses
        User::factory()->count(4)->create()->each(function ($user) {
            Business::factory()->create([
                'user_id' => $user->id,
                'name' => $user->first_name . "'s Business",
            ]);
        });
    }
}
