<?php

namespace App\Services\User;

use App\Helpers\Helper;
use InvalidArgumentException;
use App\Helpers\Enums\DecideType;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Repositories\User\UserRepository;

class UserServiceImplement extends Service implements UserService
{
  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  public function __construct(
    protected UserRepository $mainRepository
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

  public function getUserNotAdmin()
  {
    try {
      DB::beginTransaction();
      return $this->mainRepository->getUserNotAdmin();
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }

  /**
   * Handle create new user data
   *
   * @param  mixed $request
   * @return void
   */
  public function handleStoreData($request)
  {
    try {
      DB::beginTransaction();

      // Tangkap Request yang tervalidasi
      $payload = $request->validated();

      // Handle upload file
      $avatar = Helper::uploadFile($request, "images/users");

      // Create data to users table
      $payload['avatar'] = $avatar;
      $payload['password'] = Hash::make(Helper::NEW_PASSWORD);

      // Give role to user
      $user = $this->mainRepository->create($payload);
      $user->assignRole($request->roles);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }

  /**
   * Update status user account.
   *
   * @param  mixed $id
   * @return void
   */
  public function handleChangeStatus($id)
  {
    try {
      DB::beginTransaction();
      // Find User
      $user = $this->findOrFail($id);

      $newStatus = ($user->status == DecideType::YES->value) ? DecideType::NO->value : DecideType::YES->value;

      // Change Status
      $this->mainRepository->update($id, [
        'status' => $newStatus,
      ]);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }

  /**
   * Handle update data user.
   *
   * @param  mixed $request
   * @param  mixed $id
   * @return void
   */
  public function handleUpdateData($request, $id)
  {
    try {
      DB::beginTransaction();
      // Tangkap Request yang tervalidasi
      $payload = $request->validated();

      // Cari user berdasarkan id
      $user = $this->mainRepository->findOrFail($id);

      if ($request->roles != null) :
        $user->removeRole($user->getRoleId());
        $user->assignRole($request->roles);
      endif;

      // Handle jika ada perubahan avatar
      $avatar = Helper::uploadFile($request, "images/users", $user->avatar);

      // Siapkan data yang akan diubah
      $payload['avatar'] = $avatar;

      $this->mainRepository->update($id, $payload);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }

  /**
   * Handle delete user data.
   *
   * @param  mixed $id
   * @return void
   */
  public function handleDeleteData($id)
  {
    try {
      DB::beginTransaction();

      // Handle delete avatar
      $user = $this->mainRepository->findOrFail($id);

      if ($user->avatar) :
        Storage::delete($user->avatar);
      endif;

      $this->mainRepository->delete($user->id);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }
}
