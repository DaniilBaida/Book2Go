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
            ['name' => 'Haircut', 'description' => 'Haircut services for men, women, and children'],
            ['name' => 'Manicure', 'description' => 'Manicure and nail art services'],
            ['name' => 'Massage', 'description' => 'Relaxing and therapeutic massages'],
            ['name' => 'Facial', 'description' => 'Skin care and facial treatments'],
            ['name' => 'Pedicure', 'description' => 'Foot care and pedicure services'],
            ['name' => 'Makeup', 'description' => 'Makeup services for events and daily wear'],
        ];

        foreach ($categories as $category) {
            ServiceCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
