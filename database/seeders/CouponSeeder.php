<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    /**
     * Seed coupons table with realistic data
     */
    public function run(): void
    {
        $coupons = [
            // Aktif - Percent Discount
            [
                'code' => 'DISCOUNT10',
                'discount_type' => 'percent',
                'discount_value' => 10,
                'min_order' => 50000,
                'expires_at' => Carbon::now()->addDays(30),
                'usage_limit' => 100,
                'used_count' => 45,
                'is_active' => true,
            ],
            [
                'code' => 'SALE20',
                'discount_type' => 'percent',
                'discount_value' => 20,
                'min_order' => 100000,
                'expires_at' => Carbon::now()->addDays(15),
                'usage_limit' => 50,
                'used_count' => 48,
                'is_active' => true,
            ],
            [
                'code' => 'WELCOME15',
                'discount_type' => 'percent',
                'discount_value' => 15,
                'min_order' => 75000,
                'expires_at' => Carbon::now()->addDays(60),
                'usage_limit' => 200,
                'used_count' => 87,
                'is_active' => true,
            ],

            // Aktif - Fixed Discount
            [
                'code' => 'SAVE50K',
                'discount_type' => 'fixed',
                'discount_value' => 50000,
                'min_order' => 200000,
                'expires_at' => Carbon::now()->addDays(45),
                'usage_limit' => 75,
                'used_count' => 32,
                'is_active' => true,
            ],
            [
                'code' => 'FLASH100K',
                'discount_type' => 'fixed',
                'discount_value' => 100000,
                'min_order' => 500000,
                'expires_at' => Carbon::now()->addDays(7),
                'usage_limit' => 25,
                'used_count' => 23,
                'is_active' => true,
            ],

            // Unlimited Usage
            [
                'code' => 'UNLIMITED25',
                'discount_type' => 'percent',
                'discount_value' => 25,
                'min_order' => 150000,
                'expires_at' => Carbon::now()->addDays(90),
                'usage_limit' => null, // Unlimited
                'used_count' => 156,
                'is_active' => true,
            ],

            // Kadaluarsa
            [
                'code' => 'EXPIRED30',
                'discount_type' => 'percent',
                'discount_value' => 30,
                'min_order' => 100000,
                'expires_at' => Carbon::now()->subDays(5),
                'usage_limit' => 100,
                'used_count' => 92,
                'is_active' => true,
            ],
            [
                'code' => 'OLDPROMO',
                'discount_type' => 'fixed',
                'discount_value' => 25000,
                'min_order' => 50000,
                'expires_at' => Carbon::now()->subDays(30),
                'usage_limit' => 50,
                'used_count' => 48,
                'is_active' => false,
            ],

            // Mendekati Limit
            [
                'code' => 'LIMITED5',
                'discount_type' => 'percent',
                'discount_value' => 12,
                'min_order' => 80000,
                'expires_at' => Carbon::now()->addDays(20),
                'usage_limit' => 10,
                'used_count' => 8,
                'is_active' => true,
            ],

            // Special Campaign
            [
                'code' => 'BIRTHDAY10',
                'discount_type' => 'percent',
                'discount_value' => 10,
                'min_order' => 0,
                'expires_at' => Carbon::now()->addDays(365),
                'usage_limit' => 500,
                'used_count' => 234,
                'is_active' => true,
            ],
            [
                'code' => 'NEWMEMBER5K',
                'discount_type' => 'fixed',
                'discount_value' => 5000,
                'min_order' => 20000,
                'expires_at' => Carbon::now()->addDays(180),
                'usage_limit' => 1000,
                'used_count' => 621,
                'is_active' => true,
            ],
            [
                'code' => 'SUMMER30',
                'discount_type' => 'percent',
                'discount_value' => 30,
                'min_order' => 200000,
                'expires_at' => Carbon::now()->subDays(10),
                'usage_limit' => 150,
                'used_count' => 150,
                'is_active' => true,
            ],
        ];

        DB::table('coupons')->insert($coupons);

        echo "✅ " . count($coupons) . " kupon berhasil dibuat!\n";
    }
}
