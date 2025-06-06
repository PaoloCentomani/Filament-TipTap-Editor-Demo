<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * The permissions to be seeded.
     *
     * @var array
     */
    protected $permissions = [
        //
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        try {
            Role::create(['name' => 'Administrator']);
        } catch (Exception $e) {
        }

        try {
            Role::create(['name' => 'User']);
        } catch (Exception $e) {
        }

        try {
            Role::create(['name' => 'Operator']);
        } catch (Exception $e) {
        }

        foreach ($this->permissions as $role => $permissions) {
            foreach ($permissions as $permission) {
                Permission::findOrCreate($permission);
            }

            Role::create(['name' => $role])
                ->givePermissionTo($permissions);
        }
    }
}
