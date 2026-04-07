<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Comida Rápida', 'slug' => 'comida-rapida'],
            ['name' => 'Comida Internacional', 'slug' => 'comida-internacional'],
            ['name' => 'Postres y Helados', 'slug' => 'postres-y-helados'],
            ['name' => 'Bebidas', 'slug' => 'bebidas'],
            ['name' => 'Farmacia', 'slug' => 'farmacia'],
            ['name' => 'Tecnología', 'slug' => 'tecnologia'],
            ['name' => 'Flores y Regalos', 'slug' => 'flores-y-regalos'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
