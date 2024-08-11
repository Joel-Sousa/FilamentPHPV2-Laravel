<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $user = User::factory()
        //     ->hasOrders(1)
        //     ->create();

            // $order = $user->orders->first();

        //     foreach(\App\Models\Product::orderByRaw('RANDOM()')->take(4)->get() as $prod){
        //         $amount = rand(1, 5);

        //         $order->items()->create([
        //             'product_id' => $prod->id,
        //             'amount' => $amount,
        //             'order_value' => $prod->price * $amount
        //         ]);
        //     }

        User::create(['name' => 'tst', 'email' => 'tst1@email.com', 'password' => Hash::make('123')]);
        UserOrder::create(['order_code' => '1', 'user_id' => '1']);
        OrderItem::create(['order_id' => '1', 'product_id' => '1', 'amount' => '2', 'order_value' => '100']);
    }
}
