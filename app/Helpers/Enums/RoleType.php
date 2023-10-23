<?php

namespace App\Helpers\Enums;

use App\Traits\EnumsToArray;

enum RoleType: string
{
  use EnumsToArray;

  case ADMIN = 'Administrator';
  case STAFF = 'Staff Persedian';
}
