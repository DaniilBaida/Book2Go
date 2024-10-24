<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::create(['name' => 'client']);
        Role::create(['name' => 'business']);
        Role::create(['name' => 'admin']);

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
    }
}
