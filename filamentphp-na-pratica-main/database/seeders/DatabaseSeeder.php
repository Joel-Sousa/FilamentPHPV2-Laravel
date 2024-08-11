<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = \App\Models\User::factory()
            ->hasOrders(1)
            ->create();

        $order = $user->orders->first();

        foreach (\App\Models\Product::orderByRaw('RANDOM()')->take(10)->get() as $prod) {
            $amount = rand(1, 5);

            $order->items()->create([
                'product_id' => $prod->id,
                'amount' => $amount,
                'order_value' => $prod->price * $amount
            ]);
        }
    }
}
