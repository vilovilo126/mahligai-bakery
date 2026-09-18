<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Roti', 'slug' => 'roti'],
            ['name' => 'Pastry', 'slug' => 'pastry'],
            ['name' => 'Kue', 'slug' => 'kue'],
            ['name' => 'Donat', 'slug' => 'donat'],
            ['name' => 'Cookies', 'slug' => 'cookies'],
        ];

        foreach ($categories as $index => $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name'], 'sort_order' => $index],
            );
        }
    }
}