<?php
// database/seeders/DatabaseSeeder.php- Seeder utama


namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting: seeder yang punya FK harus dipanggil setelah parent-nya
        $this->call([
            AdminUserSeeder::class,   // 1. Admin user
            UserSeeder::class,        // 2. Regular users
            CategorySeeder::class,    // 3. Categories
            ProductSeeder::class,     // 4. Products (needs category)
            ReviewSeeder::class,      // 5. Reviews (needs user & product)
            CouponSeeder::class,      // 6. Coupons (independent)
            OrderSeeder::class,       // 7. Orders
        ]);
    }
}

