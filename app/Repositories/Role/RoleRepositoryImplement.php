<?php

namespace App\Repositories\Role;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Role;

class RoleRepositoryImplement extends Eloquent implements RoleRepository
{

  /**
   * Model class to be used in this repository for the common methods inside Eloquent
   * Don't remove or change $this->model variable name
   * @property Model|mixed $model;
   */
  public function __construct(protected Role $model)
  {
    // 
  }

  // Base Query
  public function getQuery()
  {
    return $this->model->query();
  }

  // Get Role Filter By Name
  public function getRoleByName($name = [])
  {
    return $this->getQuery()->select('*')
      ->whereIn('name', $name)
      ->oldest('name');
  }

  /**
   * Look for role data that has permissions
   */
  public function getRoleHasPermissions($id)
  {
    $role = $this->findOrFail($id);
    if ($role) :
      return $role->permissions->pluck('name')->toArray();
    endif;

    return [];
  }
}
