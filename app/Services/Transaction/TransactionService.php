<?php

namespace App\Services\Transaction;

use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface TransactionService extends BaseService
{
  public function getQuery();
  public function getWhere($wheres = [], $columns = '*', $comparisons = '=', $orderBy = null, $orderByType = null);
  public function handleStoreData(Request $request);
  public function handleDeleteData(int $id);
}
