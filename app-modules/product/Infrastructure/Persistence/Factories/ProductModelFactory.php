<?php

namespace AppModules\Product\Infrastructure\Persistence\Factories;

use AppModules\Product\Infrastructure\Persistence\Models\ProductModel;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductModelFactory extends Factory
{

    protected $model = ProductModel::class;


    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'stock' => $this->faker->numberBetween(0, 100),
            'sku' => $this->faker->unique()->word(),
            'is_active' => $this->faker->boolean(),
            'is_featured' => $this->faker->boolean(),
            'image' => $this->faker->imageUrl(640, 480, 'products', true, 'Product'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
