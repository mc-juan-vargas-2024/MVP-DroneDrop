<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ─── Usuario cliente de prueba ───
        User::create([
            'name'     => 'Juan Jose Vargas',
            'email'    => 'juanjose@correo.com',
            'password' => bcrypt('password'),
            'role'     => 'user',
        ]);

        // ─── Usuario repartidor de prueba ───
        User::create([
            'name'     => 'Amado',
            'email'    => 'repartidor@correo.com',
            'password' => bcrypt('password'),
            'role'     => 'courier',
        ]);

        // ─── Categorías y Comercio con productos ───
        $this->call([
            CategorySeeder::class,
            CommerceSeeder::class,
        ]);
    }
}
