<?php

namespace Database\Factories;

use App\Models\Fund;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DigitalObject>
 */
class DigitalObjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'image_name' => fake()->imageUrl(),
            'image_thumb' => fake()->imageUrl(),
            'image_derivative' => fake()->imageUrl(),
            'fund_id' => fn() => Fund::factory(),
            'inventory_number' => fake()->unique()->bothify('INV-??###'),
            'website_link' => 'https://arquivo-abm.madeira.gov.pt/',
            'status' => fake()->randomElement([0, 1, 2]),
        ];
    }
}
