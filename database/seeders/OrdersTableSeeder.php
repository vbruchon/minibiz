<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Customer;

class OrdersTableSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            Order::factory()->count(rand(1, 5))->create([
                'customer_id' => $customer->id
            ]);
        }
    }
}
