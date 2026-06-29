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
            RolePermissionSeeder::class, // 1. Roles & permissions
            AdminUserSeeder::class,      // 2. Admin user
            UserSeeder::class,           // 3. Regular users
            CategorySeeder::class,       // 4. Categories
            ProductSeeder::class,        // 5. Products (needs category)
            ReviewSeeder::class,         // 6. Reviews (needs user & product)
            CouponSeeder::class,         // 7. Coupons (independent)
            OrderSeeder::class,          // 8. Orders
        ]);
    }
}

