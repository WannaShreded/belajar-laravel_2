<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()?->id ?? User::factory(),
            'product_id' => Product::query()->inRandomOrder()->first()?->id ?? Product::factory(),
            'rating' => $this->generateRealisticRating(),
            'comment' => $this->faker->optional(0.7)->paragraph(),
        ];
    }

    /**
     * Generate realistic rating distribution:
     * - 40% rating 5
     * - 30% rating 4
     * - 20% rating 3
     * - 10% rating 1-2
     */
    private function generateRealisticRating(): int
    {
        $random = $this->faker->randomFloat(2, 0, 100);

        if ($random < 40) {
            return 5;
        } elseif ($random < 70) {
            return 4;
        } elseif ($random < 90) {
            return 3;
        } else {
            return $this->faker->randomElement([1, 2]);
        }
    }

    /**
     * State: Highly rated reviews (4-5 stars)
     */
    public function highlyRated(): static
    {
        return $this->state(['rating' => $this->faker->randomElement([4, 5])]);
    }

    /**
     * State: Poorly rated reviews (1-2 stars)
     */
    public function poorlyRated(): static
    {
        return $this->state(['rating' => $this->faker->randomElement([1, 2])]);
    }

    /**
     * State: With detailed comment
     */
    public function withComment(): static
    {
        return $this->state(['comment' => $this->faker->paragraph(3)]);
    }

    /**
     * State: Without comment
     */
    public function withoutComment(): static
    {
        return $this->state(['comment' => null]);
    }
}
