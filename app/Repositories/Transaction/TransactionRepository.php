<?php

namespace App\Repositories\Transaction;

use LaravelEasyRepository\Repository;

interface TransactionRepository extends Repository
{
  public function getQuery();
  public function getWhere($wheres = [], $columns = '*', $comparisons = '=', $orderBy = null, $orderByType = null);
}
