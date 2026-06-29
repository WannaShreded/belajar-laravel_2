<?php
// File: database/seeders/RolePermissionSeeder.php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // Buat permission
        $permissions = [
            'view-dashboard',
            'view-users',
            'edit-users',
            'delete-users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat role Admin dan beri semua permission
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::pluck('name')->toArray());

        // Buat role Manager, hanya boleh akses dashboard
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->syncPermissions(['view-dashboard']);

        // Buat user Admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->assignRole('admin');

        // Buat user Manager
        $managerUser = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $managerUser->assignRole('manager');
    }
}

