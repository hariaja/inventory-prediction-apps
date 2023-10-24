<?php

namespace App\Services\User;

use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface UserService extends BaseService
{
  public function getQuery();
  public function getUserNotAdmin();
  public function handleChangeStatus(int $id);
  public function handleStoreData(Request $request);
  public function handleUpdateData(Request $request, int $id);
  public function handleDeleteData(int $id);
}
