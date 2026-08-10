<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'slug');

        $products = [
            // Panadería
            ['category' => 'panaderia', 'name' => 'Pan francés', 'price' => 0.15, 'cost' => 0.08, 'stock' => 200],
            ['category' => 'panaderia', 'name' => 'Semita de piña', 'price' => 0.50, 'cost' => 0.25, 'stock' => 50],
            ['category' => 'panaderia', 'name' => 'Pan dulce surtido', 'price' => 0.35, 'cost' => 0.18, 'stock' => 80],
            ['category' => 'panaderia', 'name' => 'Quesadilla', 'price' => 1.00, 'cost' => 0.50, 'stock' => 30],
            ['category' => 'panaderia', 'name' => 'Marquesote', 'price' => 0.75, 'cost' => 0.35, 'stock' => 25],

            // Galletas
            ['category' => 'galletas', 'name' => 'Galleta de chocolate', 'price' => 0.50, 'cost' => 0.20, 'stock' => 100],
            ['category' => 'galletas', 'name' => 'Galleta de vainilla', 'price' => 0.50, 'cost' => 0.20, 'stock' => 100],
            ['category' => 'galletas', 'name' => 'Galleta de coco', 'price' => 0.60, 'cost' => 0.25, 'stock' => 60],
            ['category' => 'galletas', 'name' => 'Galleta de mantequilla', 'price' => 0.45, 'cost' => 0.20, 'stock' => 75],

            // Postres
            ['category' => 'postres', 'name' => 'Tres leches (porción)', 'price' => 2.50, 'cost' => 1.00, 'stock' => 20],
            ['category' => 'postres', 'name' => 'Flan de caramelo', 'price' => 1.75, 'cost' => 0.70, 'stock' => 15],
            ['category' => 'postres', 'name' => 'Brownie', 'price' => 1.50, 'cost' => 0.60, 'stock' => 30],
            ['category' => 'postres', 'name' => 'Donas glaseadas', 'price' => 1.25, 'cost' => 0.50, 'stock' => 40],
            ['category' => 'postres', 'name' => 'Cake pop', 'price' => 1.00, 'cost' => 0.40, 'stock' => 3, 'stock_alert_level' => 5],

            // Bebidas
            ['category' => 'bebidas', 'name' => 'Café americano', 'price' => 1.50, 'cost' => 0.30, 'stock' => 999],
            ['category' => 'bebidas', 'name' => 'Café con leche', 'price' => 2.00, 'cost' => 0.50, 'stock' => 999],
            ['category' => 'bebidas', 'name' => 'Chocolate caliente', 'price' => 2.25, 'cost' => 0.60, 'stock' => 999],
            ['category' => 'bebidas', 'name' => 'Jugo de naranja', 'price' => 1.75, 'cost' => 0.50, 'stock' => 50],
            ['category' => 'bebidas', 'name' => 'Agua embotellada', 'price' => 0.75, 'cost' => 0.25, 'stock' => 100],

            // Snacks
            ['category' => 'snacks', 'name' => 'Empanada de frijol', 'price' => 0.75, 'cost' => 0.30, 'stock' => 40],
            ['category' => 'snacks', 'name' => 'Pastelito de carne', 'price' => 1.00, 'cost' => 0.45, 'stock' => 35],
            ['category' => 'snacks', 'name' => 'Pupusa de queso', 'price' => 0.50, 'cost' => 0.20, 'stock' => 2, 'stock_alert_level' => 10],
        ];

        foreach ($products as $data) {
            $categoryId = $categories[$data['category']] ?? null;
            unset($data['category']);

            Product::create(array_merge($data, [
                'category_id' => $categoryId,
                'stock_alert_level' => $data['stock_alert_level'] ?? 5,
            ]));
        }
    }
}
