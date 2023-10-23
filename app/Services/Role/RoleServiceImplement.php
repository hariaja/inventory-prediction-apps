<?php

namespace App\Services\Role;

use App\Models\Role;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Log;
use App\Repositories\Role\RoleRepository;

class RoleServiceImplement extends Service implements RoleService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  public function __construct(
    protected RoleRepository $mainRepository
  ) {
    // 
  }

  public function getQuery()
  {
    try {
      DB::beginTransaction();
      return $this->mainRepository->getQuery();
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }

  public function getRoleByName($name = [])
  {
    try {
      DB::beginTransaction();
      return $this->mainRepository->getRoleByName($name);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }

  public function getRoleHasPermissions($id)
  {
    try {
      DB::beginTransaction();
      return $this->mainRepository->getRoleHasPermissions($id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }

  public function handleNewRole($request)
  {
    try {
      DB::beginTransaction();
      // Create a new Role & Sync permissions
      $create = $this->mainRepository->create($request->validated());
      $create->syncPermissions($request->permission);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }

  public function handleUpdateRole($request, $id)
  {
    try {
      DB::beginTransaction();
      $role = $this->mainRepository->findOrFail($id); // Find a Role
      $this->mainRepository->update($role->id, $request->validated()); // Update a Existing role
      $role->syncPermissions($request->permission); // sync with Permissions
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }
}
