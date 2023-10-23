<?php

namespace App\Services\Role;

use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface RoleService extends BaseService
{
  public function getQuery();
  public function getRoleByName(array $name = []);
  public function getRoleHasPermissions($id);
  public function handleNewRole(Request $request);
  public function handleUpdateRole(Request $request, int $id);
}
