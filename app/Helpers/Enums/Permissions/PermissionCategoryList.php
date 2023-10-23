<?php

namespace App\Helpers\Enums\Permissions;

use App\Traits\EnumsToArray;

enum PermissionCategoryList: string
{
  use EnumsToArray;

  case USERS = 'users.name';
  case ROLES = 'roles.name';
}
