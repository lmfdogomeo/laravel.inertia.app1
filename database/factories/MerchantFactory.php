<?php

namespace Database\Factories;

use Database\Fakers\CompanyFakerProvider;
use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Merchant>
 */
class MerchantFactory extends Factory
{
    protected $model = Merchant::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Register the custom provider
        $this->faker->addProvider(new CompanyFakerProvider($this->faker));

        return [
            'uuid' => $this->faker->uuid,
            'company_name' => $this->faker->company,
            'company_tax_id' => $this->faker->unique()->companyTaxId(), // Custom provider needed for tax ID
            'contact_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'postal_code' => $this->faker->fourDigitPostalCode(),
        ];
    }

    public function withProducts($count = 5)
    {
        return $this->has(Product::factory()->count($count), 'products');
    }
}
