<?php

namespace App\Helpers\Fuzzy;

class Sale
{
  public static function turun($sale)
  {
    if ($sale <= 5) {
      return 1;
    } elseif ($sale >= 12) {
      return 0;
    } elseif ($sale > 5 and $sale < 12) {
      return (12 - $sale) / (12 - 5);
    }
  }

  public static function tetap($sale)
  {
    if ($sale <= 5 || $sale >= 20) {
      return 0;
    } elseif ($sale >= 5 and $sale <= 12) {
      return ($sale - 5) / (12 - 5);
    } elseif ($sale > 12 and $sale < 20) {
      return (20 - $sale) / (20 - 12);
    }
  }

  public static function tinggi($sale)
  {
    if ($sale <= 12) {
      return 0;
    } elseif ($sale >= 20) {
      return 1;
    } elseif ($sale > 12 and $sale < 20) {
      return ($sale - 12) / (20 - 12);
    }
  }
}
