<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ketua_rw = Role::firstOrCreate(['name' => 'ketua_rw']);
        $actions = ['view', 'view_any', 'create', 'update', 'delete', 'delete_any', 'restore', 'restore_any', 'force_delete', 'force_delete_any', 'replicate', 'reorder'];
        $resources = ['user', 'rt', 'penduduk'];
        foreach ($resources as $resource) {
            $permissions = collect($actions)->map(fn($action) => "{$action}_{$resource}");
            $ketua_rw->givePermissionTo($permissions);
        }
    }
}
