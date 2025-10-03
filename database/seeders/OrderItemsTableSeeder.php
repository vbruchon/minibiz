<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;

class OrderItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        Order::all()->each(function ($order) use ($products) {
            $items = $products->random(rand(1, 5));
            foreach ($items as $product) {
                $quantity = rand(1, 3);
                $subtotal = $product->price * $quantity;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);
                $order->total += $subtotal;
            }
            $order->save();
        });
    }
}
