<?php

namespace App\Services\Material;

use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface MaterialService extends BaseService
{
  public function getQuery();
  public function getWhere($wheres = [], $columns = '*', $comparisons = '=', $orderBy = null, $orderByType = null);
  public function handleStoreData(Request $request);
}
