<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'category.view', 'category.create', 'category.edit', 'category.delete',
            'unit.view', 'unit.create', 'unit.edit', 'unit.delete',
            'supplier.view', 'supplier.create', 'supplier.edit', 'supplier.delete',
            'customer.view', 'customer.create', 'customer.edit', 'customer.delete',
            'product.view', 'product.create', 'product.edit', 'product.delete', 'product.view_cost',
            'stock.view', 'stock.adjust', 'pos.access',
            'sale.view', 'sale.create', 'sale.delete', 'sale.return',
            'report.view', 'report.export',
            'user.view', 'user.create', 'user.edit', 'user.delete',
            'setting.view', 'setting.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        $staff = Role::firstOrCreate(['name' => 'staff']);
        $staff->syncPermissions([
            'category.view', 'category.create', 'category.edit', 'unit.view',
            'supplier.view', 'supplier.create', 'supplier.edit',
            'customer.view', 'customer.create', 'customer.edit',
            'product.view', 'product.create', 'product.edit', 'product.view_cost',
            'stock.view', 'stock.adjust', 'sale.view', 'sale.return', 'report.view', 'report.export',
        ]);

        $cashier = Role::firstOrCreate(['name' => 'cashier']);
        $cashier->syncPermissions([
            'product.view', 'customer.view', 'customer.create', 'pos.access', 'sale.view', 'sale.create',
        ]);
    }
}