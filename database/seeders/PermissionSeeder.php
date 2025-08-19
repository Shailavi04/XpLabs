<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $defaultPermissions = ['view', 'create', 'edit', 'delete'];
        $modules = Module::all();

        foreach ($modules as $module) {
            foreach ($defaultPermissions as $perm) {
                $permissionName = "{$perm}_{$module->slug}";

                Permission::updateOrCreate(
                    [
                        'name' => $permissionName,
                        'guard_name' => 'web',
                        'module_id' => $module->id,
                    ],
                    [
                        'name' => $permissionName,
                        'guard_name' => 'web',
                        'module_id' => $module->id,
                    ]
                );
            }
        }
    }
}
