<?php

namespace Database\Seeders;

use App\Models\Rw;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat roles
        $adminRole = Role::firstOrCreate(['name' => 'admin_kelurahan']);
        $rwRole = Role::firstOrCreate(['name' => 'ketua_rw']);

        // Buat permissions
        $permissions = [
            'view_penduduk',
            'create_penduduk',
            'edit_penduduk',
            'delete_penduduk',
            'manage_master_data',
            'manage_hak_akses',
            // ... tambah lainnya
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Assign semua permission ke admin
        $adminRole->syncPermissions(Permission::all());

        // Assign permission terbatas ke ketua_rw
        $rwRole->syncPermissions([
            'view_penduduk',
            'create_penduduk',
        ]);

        // Buat user admin
        $admin = User::firstOrCreate([
            'email' => 'admin@kelurahan.test',
        ], [
            'name' => 'Admin Kelurahan',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);

        // Buat user ketua RW
        $rw = Rw::firstOrCreate(['nomor' => '003']);
        $ketuaRW = User::firstOrCreate([
            'email' => 'rw03@kelurahan.test',
        ], [
            'name' => 'Ketua RW 03',
            'password' => Hash::make('password'),
            'rw_id' => $rw->id,
        ]);
        $ketuaRW->assignRole($rwRole);
    }
}
