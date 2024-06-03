<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Merchant;
use App\Models\Product;
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

        // \App\Models\ProductCategory::create([
        //     'category' => 'Electronics',
        //     'description' => 'Electronics',
        // ]);

        // \App\Models\ProductCategory::create([
        //     'category' => 'Groceries',
        //     'description' => 'Groceries',
        // ]);

        // \App\Models\ProductCategory::create([
        //     'category' => 'Fashion',
        //     'description' => 'Fashion',
        // ]);

        // \App\Models\ProductCategory::create([
        //     'category' => 'Services',
        //     'description' => 'Services',
        // ]);

        // Merchant::factory()->count(5)->create();

        // Merchant::factory()
        //     ->count(10)
        //     ->has(Product::factory()->count(rand(50, 100)))
        //     ->create();

        // Create 10 merchants
        $merchants = Merchant::factory()->count(10)->create();

        // For each merchant, create a random number of products (between 1 and 10 for example)
        $merchants->each(function ($merchant) {
            $productCount = rand(50, 100); // Generate a random number between 1 and 10
            Product::factory()->count($productCount)->create(['merchant_id' => $merchant->id]);
        });

    }
}
