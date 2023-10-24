<?php

namespace App\Services\Transaction;

use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface TransactionService extends BaseService
{
  public function getQuery();
  public function handleStoreData(Request $request);
  public function handleDeleteData(int $id);
}
