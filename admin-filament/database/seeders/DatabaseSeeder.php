<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create(['name' => 'admin', 'email' => 'admin@email.com', 'password' => Hash::make('123')]);
        User::create(['name' => 'tst', 'email' => 'tst@email.com', 'password' => Hash::make('123')]);

        \App\Models\Product::factory(5)->create();

        $this->call([
            UserOrderSeeder::class,
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
