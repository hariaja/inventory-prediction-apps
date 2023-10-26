<?php

namespace App\Repositories\PermissionCategory;

use LaravelEasyRepository\Repository;

interface PermissionCategoryRepository extends Repository
{
  public function getQuery();
  public function with(array $with = []);
  public function getWhere($wheres = [], $columns = '*', $comparisons = '=', $orderBy = null, $orderByType = null);
}
