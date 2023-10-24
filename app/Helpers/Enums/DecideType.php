<?php

namespace App\Helpers\Enums;

use App\Traits\EnumsToArray;

enum DecideType: int
{
  use EnumsToArray;

  case YES = 1;
  case NO = 0;
}
