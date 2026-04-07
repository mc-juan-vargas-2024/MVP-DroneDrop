<?php

namespace Database\Seeders;

use App\Models\Commerce;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CommerceSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Crear usuario comercio "Juan Chaparro" ───
        $chaparro = User::create([
            'name'     => 'Juan Chaparro',
            'email'    => 'chaparro@correo.com',
            'password' => bcrypt('password'),
            'role'     => 'commerce',
        ]);

        // ─── Crear comercio ───
        $commerce = Commerce::create([
            'user_id'      => $chaparro->id,
            'name'         => 'juan chaparro',
            'address'      => 'Calle 10 #5-30, Centro',
            'latitude'     => 4.6097100,
            'longitude'    => -74.0817500,
            'opening_time' => '08:00',
            'closing_time' => '22:00',
        ]);

        // ─── Copiar imágenes seed a storage ───
        $seedImagesPath = database_path('seeders/images/products');
        $storagePath    = storage_path('app/public/products');

        if (!File::isDirectory($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        // Copiar todas las imágenes seed al storage público
        if (File::isDirectory($seedImagesPath)) {
            foreach (File::files($seedImagesPath) as $file) {
                File::copy($file->getPathname(), $storagePath . '/' . $file->getFilename());
            }
        }

        // ─── Obtener IDs de categorías ───
        $catComidaRapida     = Category::where('slug', 'comida-rapida')->first()->id;
        $catInternacional    = Category::where('slug', 'comida-internacional')->first()->id;
        $catPostres          = Category::where('slug', 'postres-y-helados')->first()->id;
        $catBebidas          = Category::where('slug', 'bebidas')->first()->id;
        $catFarmacia         = Category::where('slug', 'farmacia')->first()->id;
        $catTecnologia       = Category::where('slug', 'tecnologia')->first()->id;
        $catFlores           = Category::where('slug', 'flores-y-regalos')->first()->id;

        // ─── 10 Productos variados estilo Rappi ───
        $products = [
            [
                'name'        => 'Hamburguesa Clásica',
                'description' => 'Deliciosa hamburguesa en pan artesanal con carne angus, lechuga fresca, tomate, queso cheddar derretido y salsa especial de la casa.',
                'price'       => 25000,
                'category_id' => $catComidaRapida,
                'image_path'  => 'products/hamburguesa.png',
            ],
            [
                'name'        => 'Pizza Pepperoni',
                'description' => 'Pizza al horno de leña con abundante pepperoni, queso mozzarella gratinado, salsa de tomate italiana y orégano fresco.',
                'price'       => 35000,
                'category_id' => $catComidaRapida,
                'image_path'  => 'products/pizza.png',
            ],
            [
                'name'        => 'Tacos Mexicanos x3',
                'description' => 'Tres tacos de carne asada al pastor con cilantro, cebolla morada, salsa verde y limón. Servidos en tortilla de maíz.',
                'price'       => 18000,
                'category_id' => $catInternacional,
                'image_path'  => 'products/tacos.png',
            ],
            [
                'name'        => 'Sushi Roll Salmón',
                'description' => 'Roll de sushi con salmón fresco, aguacate cremoso, queso crema Philadelphia y arroz de sushi. Viene con salsa de soya y jengibre.',
                'price'       => 32000,
                'category_id' => $catInternacional,
                'image_path'  => 'products/sushi.png',
            ],
            [
                'name'        => 'Helado de Chocolate',
                'description' => 'Dos bolas de helado artesanal de chocolate belga con trozos de chocolatina y sirope de chocolate caliente.',
                'price'       => 12000,
                'category_id' => $catPostres,
                'image_path'  => 'products/helado.png',
            ],
            [
                'name'        => 'Jugo Natural de Naranja',
                'description' => 'Jugo 100% natural de naranja recién exprimida, sin azúcar añadida ni conservantes. Vaso de 16oz bien frío.',
                'price'       => 8000,
                'category_id' => $catBebidas,
                'image_path'  => 'products/jugo_naranja.png',
            ],
            [
                'name'        => 'Agua Cristal 600ml',
                'description' => 'Botella de agua purificada de 600ml, ideal para refrescarte en cualquier momento del día.',
                'price'       => 3000,
                'category_id' => $catBebidas,
                'image_path'  => 'products/agua.jpg',
            ],
            [
                'name'        => 'Kit de Aspirinas x10',
                'description' => 'Caja de 10 tabletas de aspirina para alivio rápido de dolor de cabeza, fiebre y malestar general. Uso responsable.',
                'price'       => 15000,
                'category_id' => $catFarmacia,
                'image_path'  => 'products/aspirinas.jpg',
            ],
            [
                'name'        => 'Audífonos Bluetooth',
                'description' => 'Audífonos inalámbricos Bluetooth 5.0, con cancelación de ruido, batería de 20 horas y diseño ergonómico plegable.',
                'price'       => 75000,
                'category_id' => $catTecnologia,
                'image_path'  => 'products/audifonos.jpg',
            ],
            [
                'name'        => 'Ramo de Flores Mixtas',
                'description' => 'Hermoso ramo de flores frescas variadas con rosas, girasoles y margaritas, envuelto en papel kraft. Perfecto para regalar.',
                'price'       => 45000,
                'category_id' => $catFlores,
                'image_path'  => 'products/flores.jpg',
            ],
        ];

        foreach ($products as $productData) {
            Product::create(array_merge($productData, [
                'commerce_id'  => $commerce->id,
                'is_available' => true,
            ]));
        }
    }
}
