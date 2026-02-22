<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Buat Permission (Anggap ini sebagai Menu yang bisa diceklis)
        $permissions = [
            'view_dashboard',
            'view_master_data', // Menu Dokter, Perawat, dll
            'view_master_medicine',
            'view_medicine_history',
            'view_clinical',    // Menu Rekam Medis
            'view_reports',     // Menu Laporan
            'laporan',          // Menu Laporan Poliklinik
            'manage_users',
            'stock_opname',
            'adjustment'     // Menu atur user (Khusus Superadmin)
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 3. Buat Role Superadmin & Staff
        $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        $roleStaff = Role::create(['name' => 'staff']);

        // 4. Buat User Superadmin
        $user = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@poliklinik.com',
            'username' => 'superadmin',
            'password' => Hash::make('123456'), // Ganti password nanti!
        ]);

        // Assign role superadmin ke user tersebut
        $user->assignRole($roleSuperAdmin);
        
        // Superadmin punya akses ke semua permission
        $roleSuperAdmin->givePermissionTo(Permission::all());
    }
}