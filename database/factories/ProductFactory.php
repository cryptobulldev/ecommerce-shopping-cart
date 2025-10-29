<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array{name: string, description: string, price: float, stock_quantity: int}
     */
    public function definition(): array
    {
        return [
            'name'           => $this->faker->word().' '.$this->faker->word(),
            'description'    => $this->faker->sentence(),
            'price'          => $this->faker->randomFloat(2, 10, 500),
            'stock_quantity' => $this->faker->numberBetween(0, 50),
        ];
    }
}
