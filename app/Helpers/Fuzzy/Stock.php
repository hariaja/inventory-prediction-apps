<?php

namespace App\Helpers\Fuzzy;

class Stock
{
  public static function sedikit($stock)
  {
    if ($stock <= 10) {
      return 1;
    } elseif ($stock >= 25) {
      return 0;
    } elseif ($stock > 10 and $stock < 25) {
      return (25 - $stock) / (25 - 10);
    }
  }

  public static function sedang($stock)
  {
    if ($stock <= 10 || $stock >= 40) {
      return 0;
    } elseif ($stock >= 10 and $stock <= 25) {
      return ($stock - 10) / (25 - 10);
    } elseif ($stock > 25 and $stock < 40) {
      return (40 - $stock) / (40 - 25);
    }
  }

  public static function tinggi($stock)
  {
    if ($stock <= 25) {
      return 0;
    } elseif ($stock >= 40) {
      return 1;
    } elseif ($stock > 25 and $stock < 40) {
      return ($stock - 25) / (40 - 25);
    }
  }
}
