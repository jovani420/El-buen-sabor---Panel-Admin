<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\Category;
use App\Models\Discount;
use App\Models\LoyaltyPoint;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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

     
      // Crear 10 categorías únicas. Faker no debería tener problemas para esto.
        Category::factory(10)->create();

        // Crear 50 productos. Cada producto se vinculará a una categoría existente.
        Product::factory(50)->create();

        // Crear 20 extras (addons) para los productos.
        Addon::factory(20)->create();

        // Crear 5 pedidos para probar el sistema de pedidos.
        Order::factory(5)->create();

        // Crear 10 descuentos
        Discount::factory(10)->create();

        // Crear 15 registros de puntos de fidelidad.
        LoyaltyPoint::factory(15)->create();

        // Adjuntar extras a los productos de forma aleatoria (relación muchos a muchos)
        $products = Product::all();
        $addons = Addon::all();

        foreach ($products as $product) {
            // Adjuntar entre 1 y 3 extras a cada producto
            $product->addons()->attach(
                $addons->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
