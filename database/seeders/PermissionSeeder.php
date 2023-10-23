<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use App\Helpers\Enums\Permissions\PermissionList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // reset cahced roles and permission
    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    $permissions = PermissionList::listPermissions();

    $guardName = 'web';
    $permissionCategoryId = [
      'users' => 1,
      'roles' => 2,
    ];

    // Masukkan atau simpan ke tabel permissions
    foreach ($permissions as $permission) :
      Permission::firstOrCreate([
        'name' => $permission,
        'permission_category_id' => $permissionCategoryId[explode('.', $permission)[0]],
        'guard_name' => $guardName,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    endforeach;
  }
}
