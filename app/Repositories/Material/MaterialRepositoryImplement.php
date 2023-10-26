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

  public function getWhere($wheres = [], $columns = '*', $comparisons = '=', $orderBy = null, $orderByType = null)
  {
    $data = $this->model->select($columns);

    if (!empty($wheres)) {
      foreach ($wheres as $key => $value) {
        if (is_array($value)) {
          $data = $data->whereIn($key, $value);
        } else {
          $data = $data->where($key, $comparisons, $value);
        }
      }
    }

    if ($orderBy) {
      $data = $data->orderBy($orderBy, $orderByType);
    }

    return $data;
  }
}
