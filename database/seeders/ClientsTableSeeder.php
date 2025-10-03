<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientsTableSeeder extends Seeder
{
    public function run(): void
    {
        Client::factory()->count(10)->create();
    }
}
