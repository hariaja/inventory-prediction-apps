<?php

namespace App\Repositories\Material;

use LaravelEasyRepository\Repository;

interface MaterialRepository extends Repository
{
  public function getQuery();
  public function getWhere($wheres = [], $columns = '*', $comparisons = '=', $orderBy = null, $orderByType = null);
}
