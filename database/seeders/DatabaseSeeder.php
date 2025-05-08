<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\AdvanceSalary;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KoperasiSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        $superadmin = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'koperasi_id' => null,
        ]);

        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'koperasi_id' => 1,
        ]);

        $user = \App\Models\User::factory()->create([
            'name' => 'User',
            'username' => 'user',
            'email' => 'user@gmail.com',
            'koperasi_id' => 2,
        ]);

        // Create data for koperasi 1
        Employee::factory(3)->create(['koperasi_id' => 1]);
        Customer::factory(15)->create(['koperasi_id' => 1]);
        Supplier::factory(5)->create(['koperasi_id' => 1]);

        // Create categories with unique slugs for koperasi 1
        for ($i = 1; $i <= 3; $i++) {
            Category::create([
                'name' => 'Category ' . $i,
                'slug' => 'category-' . $i,
                'koperasi_id' => 1
            ]);
        }

        // Create products for koperasi 1
        for ($i=0; $i < 5; $i++) {
            Product::factory()->create([
                'product_code' => IdGenerator::generate([
                    'table' => 'products',
                    'field' => 'product_code',
                    'length' => 4,
                    'prefix' => 'PC'
                ]),
                'koperasi_id' => 1
            ]);
        }

        // Create data for koperasi 2
        Employee::factory(2)->create(['koperasi_id' => 2]);
        Customer::factory(10)->create(['koperasi_id' => 2]);
        Supplier::factory(5)->create(['koperasi_id' => 2]);

        // Create categories with unique slugs for koperasi 2
        for ($i = 4; $i <= 5; $i++) {
            Category::create([
                'name' => 'Category ' . $i,
                'slug' => 'category-' . $i,
                'koperasi_id' => 2
            ]);
        }

        // Create products for koperasi 2
        for ($i=0; $i < 5; $i++) {
            Product::factory()->create([
                'product_code' => IdGenerator::generate([
                    'table' => 'products',
                    'field' => 'product_code',
                    'length' => 4,
                    'prefix' => 'PC'
                ]),
                'koperasi_id' => 2
            ]);
        }

        Permission::create(['name' => 'pos.menu', 'group_name' => 'pos']);
        Permission::create(['name' => 'employee.menu', 'group_name' => 'employee']);
        Permission::create(['name' => 'customer.menu', 'group_name' => 'customer']);
        Permission::create(['name' => 'supplier.menu', 'group_name' => 'supplier']);
        Permission::create(['name' => 'salary.menu', 'group_name' => 'salary']);
        Permission::create(['name' => 'attendence.menu', 'group_name' => 'attendence']);
        Permission::create(['name' => 'category.menu', 'group_name' => 'category']);
        Permission::create(['name' => 'product.menu', 'group_name' => 'product']);
        Permission::create(['name' => 'expense.menu', 'group_name' => 'expense']);
        Permission::create(['name' => 'orders.menu', 'group_name' => 'orders']);
        Permission::create(['name' => 'stock.menu', 'group_name' => 'stock']);
        Permission::create(['name' => 'roles.menu', 'group_name' => 'roles']);
        Permission::create(['name' => 'user.menu', 'group_name' => 'user']);
        Permission::create(['name' => 'user.create', 'group_name' => 'user']);
        Permission::create(['name' => 'user.edit', 'group_name' => 'user']);
        Permission::create(['name' => 'user.delete', 'group_name' => 'user']);
        Permission::create(['name' => 'koperasi.menu', 'group_name' => 'koperasi']);
        Permission::create(['name' => 'koperasi.create', 'group_name' => 'koperasi']);
        Permission::create(['name' => 'koperasi.edit', 'group_name' => 'koperasi']);
        Permission::create(['name' => 'koperasi.delete', 'group_name' => 'koperasi']);

        $role = Role::create(['name' => 'superadmin']);
        $role->givePermissionTo(Permission::all());
        $superadmin->assignRole($role);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
        $admin->assignRole($role);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo([
            'pos.menu',
            'customer.menu',
            'supplier.menu',
            'category.menu',
            'product.menu',
            'expense.menu',
            'orders.menu',
            'stock.menu',
        ]);
        $user->assignRole($role);
    }
}
