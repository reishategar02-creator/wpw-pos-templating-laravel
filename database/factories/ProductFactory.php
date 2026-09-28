<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->words(2, true),
            'category'    => $this->faker->randomElement([
                'Makanan', 'Minuman', 'Kebutuhan Rumah Tangga', 'Obat-obatan',
            ]),
            'description' => $this->faker->sentence(),
            'price'       => $this->faker->numberBetween(2000, 50000),
            'stock'       => $this->faker->numberBetween(5, 100),
            'image'       => null,
            'is_active'   => true,
        ];
    }
}