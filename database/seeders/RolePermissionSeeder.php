<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['manage students', 'manage courses', 'manage registrations', 'view assigned courses', 'view own registrations'];
        foreach ($permissions as $permission) Permission::findOrCreate($permission, 'web');
        $permissionModels = Permission::whereIn('name', $permissions)->where('guard_name', 'web')->get();
        $admin = Role::findOrCreate('admin', 'web'); $lecturer = Role::findOrCreate('lecturer', 'web'); $student = Role::findOrCreate('student', 'web');
        $admin->syncPermissions($permissionModels); $lecturer->syncPermissions($permissionModels->whereIn('name', ['view assigned courses'])); $student->syncPermissions($permissionModels->whereIn('name', ['view own registrations']));
        $adminUser = User::firstOrCreate(['email' => 'admin@unipilot.test'], ['name' => 'System Administrator', 'password' => 'password']); $adminUser->assignRole('admin');
        $lecturerUser = User::firstOrCreate(['email' => 'lecturer@unipilot.test'], ['name' => 'Dr. Grace Lecturer', 'password' => 'password']); $lecturerUser->assignRole('lecturer');
    }
}
