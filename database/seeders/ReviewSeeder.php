<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Seed reviews with realistic distribution and consistent relationships.
     */
    public function run(): void
    {
        // Get all users and products
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            echo "⚠️  Ensure UserSeeder and ProductSeeder are run first!\n";
            return;
        }

        $userCount = $users->count();
        $productCount = $products->count();
        $maxPossibleReviews = $userCount * $productCount;
        $reviewsToCreate = min(300, $maxPossibleReviews);

        echo "📊 Creating {$reviewsToCreate} reviews from {$userCount} users and {$productCount} products\n";

        // Generate unique (user_id, product_id) pairs
        $createdPairs = [];
        $reviewsData = [];

        $attempts = 0;
        $maxAttempts = $reviewsToCreate * 3; // Safety limit to prevent infinite loops

        while (count($reviewsData) < $reviewsToCreate && $attempts < $maxAttempts) {
            $userId = $users->random()->id;
            $productId = $products->random()->id;
            $pair = "{$userId}_{$productId}";

            // Skip if this pair already exists
            if (!in_array($pair, $createdPairs)) {
                $createdPairs[] = $pair;
                $reviewsData[] = [
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'rating' => $this->generateRealisticRating(),
                    'comment' => fake()->optional(0.7)->paragraph(),
                    'created_at' => now()->subDays(rand(0, 180)),
                    'updated_at' => now(),
                ];
            }

            $attempts++;
        }

        // Insert in chunks to avoid memory issues
        collect($reviewsData)->chunk(100)->each(function ($chunk) {
            Review::insert($chunk->toArray());
        });

        echo "✅ Successfully created " . count($reviewsData) . " reviews!\n";
    }

    /**
     * Generate realistic rating distribution
     */
    private function generateRealisticRating(): int
    {
        $random = fake()->randomFloat(2, 0, 100);

        if ($random < 40) {
            return 5; // 40%
        } elseif ($random < 70) {
            return 4; // 30%
        } elseif ($random < 90) {
            return 3; // 20%
        } else {
            return fake()->randomElement([1, 2]); // 10%
        }
    }
}
