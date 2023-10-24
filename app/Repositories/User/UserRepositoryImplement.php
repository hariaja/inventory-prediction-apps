<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;

class UserRepositoryImplement extends Eloquent implements UserRepository
{
  /**
   * Model class to be used in this repository for the common methods inside Eloquent
   * Don't remove or change $this->model variable name
   * @property Model|mixed $model;
   */
  public function __construct(protected User $model)
  {
    // 
  }

  /**
   * Base query
   */
  public function getQuery()
  {
    return $this->model->query();
  }

  /**
   * This method to get all users except administrator.
   *
   * @return void
   */
  public function getUserNotAdmin()
  {
    return $this->getQuery()->select('*')->whereNotAdmin();
  }
}
