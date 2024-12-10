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
            ['name' => 'Math Tutoring', 'description' => 'Tutoring sessions for students of all levels'],
            ['name' => 'Photography', 'description' => 'Professional photography for events and portraits'],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}
