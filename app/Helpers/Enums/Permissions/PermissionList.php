<?php

namespace App\Helpers\Enums\Permissions;

class PermissionList
{
  public static function listPermissions()
  {
    // Ini adalah permissions atau hak akses yang 
    // diberikan berdasarkan nama route dan di kategorikan berdasarkan nama permission category

    return [
      // Halaman User
      'users.index',
      'users.create',
      'users.store',
      'users.show',
      'users.password',
      'users.edit',
      'users.update',
      'users.destroy',

      // Halaman Role
      'roles.index',
      'roles.edit',
      'roles.update',
      'roles.destroy',
    ];
  }
}
