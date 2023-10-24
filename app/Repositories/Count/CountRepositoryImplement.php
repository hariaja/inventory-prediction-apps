<?php

namespace App\Repositories\Count;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Count;

class CountRepositoryImplement extends Eloquent implements CountRepository
{
  /**
   * Model class to be used in this repository for the common methods inside Eloquent
   * Don't remove or change $this->model variable name
   * @property Model|mixed $model;
   */
  protected $model;

  public function __construct(Count $model)
  {
    $this->model = $model;
  }

  /**
   * Base Query
   */
  public function getQuery()
  {
    return $this->model->query();
  }
}
