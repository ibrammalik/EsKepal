<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_role","view_any_role","create_role","update_role","restore_role","restore_any_role","replicate_role","reorder_role","delete_role","delete_any_role","force_delete_role","force_delete_any_role"]},{"name":"ketua_rw","guard_name":"web","permissions":["view_user","view_any_user","create_user","update_user","delete_user","delete_any_user","restore_user","restore_any_user","force_delete_user","force_delete_any_user","replicate_user","reorder_user","view_rt","view_any_rt","create_rt","update_rt","delete_rt","delete_any_rt","restore_rt","restore_any_rt","force_delete_rt","force_delete_any_rt","replicate_rt","reorder_rt","view_penduduk","view_any_penduduk","create_penduduk","update_penduduk","delete_penduduk","delete_any_penduduk","restore_penduduk","restore_any_penduduk","force_delete_penduduk","force_delete_any_penduduk","replicate_penduduk","reorder_penduduk"]}]';
        $directPermissions = '{"12":{"name":"view_agama","guard_name":"web"},"13":{"name":"view_any_agama","guard_name":"web"},"14":{"name":"create_agama","guard_name":"web"},"15":{"name":"update_agama","guard_name":"web"},"16":{"name":"restore_agama","guard_name":"web"},"17":{"name":"restore_any_agama","guard_name":"web"},"18":{"name":"replicate_agama","guard_name":"web"},"19":{"name":"reorder_agama","guard_name":"web"},"20":{"name":"delete_agama","guard_name":"web"},"21":{"name":"delete_any_agama","guard_name":"web"},"22":{"name":"force_delete_agama","guard_name":"web"},"23":{"name":"force_delete_any_agama","guard_name":"web"},"24":{"name":"view_pekerjaan","guard_name":"web"},"25":{"name":"view_any_pekerjaan","guard_name":"web"},"26":{"name":"create_pekerjaan","guard_name":"web"},"27":{"name":"update_pekerjaan","guard_name":"web"},"28":{"name":"restore_pekerjaan","guard_name":"web"},"29":{"name":"restore_any_pekerjaan","guard_name":"web"},"30":{"name":"replicate_pekerjaan","guard_name":"web"},"31":{"name":"reorder_pekerjaan","guard_name":"web"},"32":{"name":"delete_pekerjaan","guard_name":"web"},"33":{"name":"delete_any_pekerjaan","guard_name":"web"},"34":{"name":"force_delete_pekerjaan","guard_name":"web"},"35":{"name":"force_delete_any_pekerjaan","guard_name":"web"},"60":{"name":"view_rw","guard_name":"web"},"61":{"name":"view_any_rw","guard_name":"web"},"62":{"name":"create_rw","guard_name":"web"},"63":{"name":"update_rw","guard_name":"web"},"64":{"name":"restore_rw","guard_name":"web"},"65":{"name":"restore_any_rw","guard_name":"web"},"66":{"name":"replicate_rw","guard_name":"web"},"67":{"name":"reorder_rw","guard_name":"web"},"68":{"name":"delete_rw","guard_name":"web"},"69":{"name":"delete_any_rw","guard_name":"web"},"70":{"name":"force_delete_rw","guard_name":"web"},"71":{"name":"force_delete_any_rw","guard_name":"web"},"72":{"name":"view_status::kependudukan","guard_name":"web"},"73":{"name":"view_any_status::kependudukan","guard_name":"web"},"74":{"name":"create_status::kependudukan","guard_name":"web"},"75":{"name":"update_status::kependudukan","guard_name":"web"},"76":{"name":"restore_status::kependudukan","guard_name":"web"},"77":{"name":"restore_any_status::kependudukan","guard_name":"web"},"78":{"name":"replicate_status::kependudukan","guard_name":"web"},"79":{"name":"reorder_status::kependudukan","guard_name":"web"},"80":{"name":"delete_status::kependudukan","guard_name":"web"},"81":{"name":"delete_any_status::kependudukan","guard_name":"web"},"82":{"name":"force_delete_status::kependudukan","guard_name":"web"},"83":{"name":"force_delete_any_status::kependudukan","guard_name":"web"},"84":{"name":"view_status::perkawinan","guard_name":"web"},"85":{"name":"view_any_status::perkawinan","guard_name":"web"},"86":{"name":"create_status::perkawinan","guard_name":"web"},"87":{"name":"update_status::perkawinan","guard_name":"web"},"88":{"name":"restore_status::perkawinan","guard_name":"web"},"89":{"name":"restore_any_status::perkawinan","guard_name":"web"},"90":{"name":"replicate_status::perkawinan","guard_name":"web"},"91":{"name":"reorder_status::perkawinan","guard_name":"web"},"92":{"name":"delete_status::perkawinan","guard_name":"web"},"93":{"name":"delete_any_status::perkawinan","guard_name":"web"},"94":{"name":"force_delete_status::perkawinan","guard_name":"web"},"95":{"name":"force_delete_any_status::perkawinan","guard_name":"web"}}';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
