<?php

namespace App\Repositories\Count;

use LaravelEasyRepository\Repository;

interface CountRepository extends Repository
{
  public function getQuery();
  public function getWhere($wheres = [], $columns = '*', $comparisons = '=', $orderBy = null, $orderByType = null);
}
