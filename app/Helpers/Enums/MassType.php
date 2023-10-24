<?php

namespace App\Helpers\Enums;

use App\Traits\EnumsToArray;

enum MassType: string
{
  use EnumsToArray;

  case GRAM = 'Gram';
  case TON = 'Ton';
  case KILO = 'Kilogram';
  case LITER = 'Liter';
}
