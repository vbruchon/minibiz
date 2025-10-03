<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Client;

class OrdersTableSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            Order::factory()->count(rand(1, 5))->create([
                'client_id' => $client->id
            ]);
        }
    }
}
