<?php

namespace App\Services\PermissionCategory;

use LaravelEasyRepository\BaseService;

interface PermissionCategoryService extends BaseService
{
  public function getQuery();
  public function with(array $with = []);
}
