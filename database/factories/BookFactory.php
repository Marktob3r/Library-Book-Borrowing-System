<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $total = fake()->numberBetween(5, 20);
            return [
                'title' => fake()->sentence(3),
                'author' => fake()->name(),
                'isbn' => fake()->numerify('978-##########'), // Generates a random 13-digit string
                'total_quantity' => $total,
                'available_quantity' => $total,
                'status' => 'Available',
            ];
    }
}
