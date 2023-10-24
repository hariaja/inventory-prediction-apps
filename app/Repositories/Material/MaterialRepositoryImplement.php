<?php

namespace App\Repositories\Material;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Material;

class MaterialRepositoryImplement extends Eloquent implements MaterialRepository
{

  /**
   * Model class to be used in this repository for the common methods inside Eloquent
   * Don't remove or change $this->model variable name
   * @property Model|mixed $model;
   */
  public function __construct(
    protected Material $model
  ) {
    // 
  }

  /**
   * Base Query
   */
  public function getQuery()
  {
    return $this->model->query();
  }
}
