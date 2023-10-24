<?php

namespace App\Services\Transaction;

use App\Helpers\Helper;
use App\Repositories\Product\ProductRepository;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Log;
use App\Repositories\Transaction\TransactionRepository;

class TransactionServiceImplement extends Service implements TransactionService
{
  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  public function __construct(
    protected ProductRepository $productRepository,
    protected TransactionRepository $mainRepository,
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

  public function getWhere($wheres = [], $columns = '*', $comparisons = '=', $orderBy = null, $orderByType = null)
  {
    try {
      DB::beginTransaction();
      return $this->mainRepository->getWhere(
        wheres: $wheres,
        columns: $columns,
        comparisons: $comparisons,
        orderBy: $orderBy,
        orderByType: $orderByType
      );
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

      $product = $this->productRepository->findOrFail($request->product_id);

      $payload = $request->validated();
      $payload['code'] = Helper::generateCode('transactions', 'code', "TR" . date('Ym'), 9, 3);
      $payload['user_id'] = me()->id;
      $payload['price'] = $request->quantity * $product->price;

      // insert to transactions table
      $this->mainRepository->create($payload);

      $product->update([
        'quantity' => (int) $product->quantity - $request->quantity,
      ]);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }

  public function handleDeleteData($id)
  {
    try {
      DB::beginTransaction();

      $transaction = $this->mainRepository->findOrFail($id);
      $product = $this->productRepository->findOrFail($transaction->product_id);

      $product->update([
        'quantity' => $product->quantity + $transaction->quantity,
      ]);

      $transaction->delete();

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }
}
