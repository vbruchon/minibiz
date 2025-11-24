<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Bill, BillLine, Product};

class BillSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('⚠️ No products found. Please seed or create some products before running this seeder.');
            return;
        }

        Bill::factory()
            ->count(5)
            ->create()
            ->each(function (Bill $bill) use ($products) {
                $product = $products->random();
                $line = BillLine::factory()->make([
                    'product_id' => $product->id,
                    'description' => $product->name,
                    'quantity' => 1,
                    'unit_price' => $product->base_price ?? 0,
                ]);
                $bill->lines()->save($line);

                $bill->update([
                    'subtotal' => $line->unit_price,
                    'tax_total' => $line->unit_price * ($line->tax_rate / 100),
                    'total' => $line->total,
                ]);
            });

        Bill::factory()
            ->count(3)
            ->invoice()
            ->create()
            ->each(function (Bill $bill) use ($products) {
                $product = $products->random();
                $line = BillLine::factory()->make([
                    'product_id' => $product->id,
                    'description' => $product->name,
                    'quantity' => 1,
                    'unit_price' => $product->base_price ?? 0,
                ]);
                $bill->lines()->save($line);

                $bill->update([
                    'subtotal' => $line->unit_price,
                    'tax_total' => $line->unit_price * ($line->tax_rate / 100),
                    'total' => $line->total,
                ]);
            });

        $this->command->info('✅ 5 quotes and 3 invoices have been successfully created, each linked to a single product.');
    }
}
