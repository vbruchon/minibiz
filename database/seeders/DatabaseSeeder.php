<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\CustomersTableSeeder;
use Database\Seeders\ProductTableSeeder;
use Database\Seeders\BillSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CustomersTableSeeder::class,
            ProductTableSeeder::class,
            BillSeeder::class,
        ]);
    }
}
