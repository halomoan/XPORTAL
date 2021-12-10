<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view invoices']);
        Permission::create(['name' => 'add invoices']);
        Permission::create(['name' => 'edit invoices']);
        Permission::create(['name' => 'delete invoices']);

        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'add roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);

         // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(['view invoices', 'add invoices','delete invoices']);

        //$role = Role::create(['name' => 'super-admin']);
        //$role->givePermissionTo(Permission::all());

    }
}
