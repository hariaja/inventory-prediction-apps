<?php

namespace App\Repositories\User;

use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface UserRepository extends Repository
{
  public function getQuery();
  public function getUserNotAdmin();
}
