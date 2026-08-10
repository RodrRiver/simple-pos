<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Panadería', 'color' => '#D4A574', 'sort_order' => 1],
            ['name' => 'Galletas', 'color' => '#E8A87C', 'sort_order' => 2],
            ['name' => 'Postres', 'color' => '#D4849A', 'sort_order' => 3],
            ['name' => 'Bebidas', 'color' => '#7EC8E3', 'sort_order' => 4],
            ['name' => 'Snacks', 'color' => '#95D5B2', 'sort_order' => 5],
            ['name' => 'Otros', 'color' => '#B8B8B8', 'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
