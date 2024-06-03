<?php

namespace Database\Factories;

use App\Models\Merchant;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fetch all category IDs
        $categoryIds = ProductCategory::pluck('id')->toArray();
        $startDate = $this->faker->dateTimeBetween('2024-01-01', '2024-12-31');

        return [
            'uuid' => $this->faker->uuid,
            'sku' => $this->faker->unique()->numerify('SKU-#####'),
            'brand_name' => $this->faker->company,
            'product_name' => $this->faker->word,
            'product_description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'sale_price' => $this->faker->randomFloat(2, 5, 500),
            'is_sale' => $this->faker->boolean,
            'quantity' => $this->faker->numberBetween(1, 1000),
            'sale' => $this->faker->numberBetween(0, 1000),
            'stock_status' => $this->faker->randomElement(\App\Enums\StockStatus::values()),
            'stock_quantity' => $this->faker->numberBetween(0, 1000),
            'sold_quantity' => $this->faker->numberBetween(0, 500),
            'unit' => $this->faker->randomElement(\App\Enums\ProductUnits::values()),
            'start_date' => $startDate->format('Y-m-d'),
            'size' => $this->faker->optional()->randomElement(['S', 'M', 'L', 'XL']),
            'weight' => $this->faker->optional()->randomFloat(2, 0.1, 10) . ' kg',
            'rate' => $this->faker->numberBetween(0, 5),
            'category_id' => $this->faker->randomElement($categoryIds), // Assign a random existing category
            'merchant_id' => Merchant::factory(),
        ];
    }
}
