<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = 'api';

        // Define permissions
        $permissions = [
            'manage-portfolio',
            'manage-users'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => $guard]);
        }

        // Create Role and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => $guard]);
        $adminRole->syncPermissions(Permission::where('guard_name', $guard)->get());

        // Create Admin User
        $adminUser = User::firstOrCreate([
            'email' => 'admin@threeeye.com',
        ], [
            'name' => 'Three Eye Admin',
            'password' => Hash::make('password123'),
        ]);

        if (!$adminUser->hasRole('Super Admin')) {
            $adminUser->assignRole($adminRole);
        }
    }
}
