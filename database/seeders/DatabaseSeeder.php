<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\ClientsTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\OrdersTableSeeder;
use Database\Seeders\OrderItemsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClientsTableSeeder::class,
            ProductsTableSeeder::class,
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
        ]);
    }
}
