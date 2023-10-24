<?php

namespace App\Services\Product;

use App\Helpers\Helper;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Log;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Carbon;

class ProductServiceImplement extends Service implements ProductService
{
  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(ProductRepository $mainRepository)
  {
    $this->mainRepository = $mainRepository;
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

  public function handleStoreData($request)
  {
    try {
      DB::beginTransaction();

      $price = $request->price;
      $unitPrice = str_replace(',', '', $price);

      $payload = $request->validated();
      $payload['code'] = Helper::generateCode('materials', 'code', "PD" . date('Ym'), 9, 3);
      $payload['expired_at'] = Carbon::parse($request->produced_at)->addWeeks(1)->format('Y-m-d');
      $payload['price'] = $unitPrice;

      $this->mainRepository->create($payload);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }

  public function handleUpdateData($request, $id)
  {
    try {
      DB::beginTransaction();

      $price = $request->price;
      $unitPrice = str_replace(',', '', $price);

      $payload = $request->validated();
      $payload['expired_at'] = Carbon::parse($request->produced_at)->addWeeks(1)->format('Y-m-d');
      $payload['price'] = $unitPrice;
      $this->mainRepository->update($id, $payload);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }
}
