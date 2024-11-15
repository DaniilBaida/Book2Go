<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Massage Therapy', 'description' => 'Relaxing and therapeutic massages'],
            ['name' => 'Haircuts & Styling', 'description' => 'Professional haircuts and styling services'],
            ['name' => 'Cleaning Services', 'description' => 'Residential and commercial cleaning'],
            ['name' => 'Car Wash', 'description' => 'Comprehensive car wash and detailing'],
            ['name' => 'Computer Repairs', 'description' => 'IT support and computer repair services'],
            ['name' => 'Math Tutoring', 'description' => 'Tutoring sessions for students of all levels'],
            ['name' => 'Photography', 'description' => 'Professional photography for events and portraits'],
            ['name' => 'Gym Memberships', 'description' => 'Access to state-of-the-art fitness facilities'],
            ['name' => 'Dog Walking', 'description' => 'Daily dog walking and pet care services'],
            ['name' => 'Travel Planning', 'description' => 'Custom travel itineraries and booking services'],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}
