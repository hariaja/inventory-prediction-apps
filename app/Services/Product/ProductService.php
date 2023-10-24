<?php

namespace App\Services\Product;

use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface ProductService extends BaseService
{
  public function getQuery();
  public function handleStoreData(Request $request);
  public function handleUpdateData(Request $request, int $id);
}
