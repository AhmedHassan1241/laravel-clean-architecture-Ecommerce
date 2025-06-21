<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define product permissions
//        Permission::create(['name' => 'view products']);
//        Permission::create(['name' => 'create products']);
//        Permission::create(['name' => 'edit products']);
//        Permission::create(['name' => 'delete products']);

        // Define order permissions
//        Permission::create(['name' => 'view orders']);
//        Permission::create(['name' => 'create orders']);
//        Permission::create(['name' => 'update orders']);
//        Permission::create(['name' => 'cancel orders']);

        // Define user permissions
//        Permission::create(['name' => 'view users']);
//        Permission::create(['name' => 'edit users']);

        // Define delivery permissions
//        Permission::create(['name' => 'view deliveries']);
//        Permission::create(['name' => 'update delivery status']); // pending-shipped-delivered

        $permissions =
            [
                'view products',
                'create products',
                'edit products',
                'delete products',
                'view orders',
                'create orders',
                'update orders',
                'cancel orders',
                'view users',
                'edit users',
                'view deliveries',
                'update delivery status',
            ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
//                'guard_name' => 'sanctum'
            ]);
        }

        // Create Admin role and assign all permissions
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
//            'guard_name' => 'sanctum'
        ]);
        $adminRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view orders',
            'update orders',
            'cancel orders',
            'view users',
            'edit users',
            'view deliveries',
            'update delivery status'
        ]);

        // Create Customer role with limited permissions
        $customerRole = Role::firstOrCreate([
            'name' => 'customer',
//            'guard_name' => 'sanctum'
        ]);
        $customerRole->givePermissionTo([
            'view products',
            'view orders',
            'create orders',
            'cancel orders'
        ]);

        // Create Delivery role
        $deliveryRole = Role::firstOrCreate([
            'name' => 'delivery',
//            'guard_name' => 'sanctum'
        ]);
        $deliveryRole->givePermissionTo([
            'view deliveries',
            'update delivery status',
            'view orders',
            'view products'
        ]);
    }
}
