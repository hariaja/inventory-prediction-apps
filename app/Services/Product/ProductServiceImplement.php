<?php

namespace App\Services\Product;

use App\Helpers\Helper;
use App\Repositories\Material\MaterialRepository;
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
  public function __construct(
    protected ProductRepository $mainRepository,
    protected MaterialRepository $materialRepository,
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

      $price = $request->price;
      $unitPrice = str_replace(',', '', $price);

      $payload = $request->validated();
      $payload['code'] = Helper::generateCode('products', 'code', "PD" . date('Ym'), 9, 3);
      $payload['expired_at'] = Carbon::parse($request->produced_at)->addWeeks(1)->format('Y-m-d');
      $payload['price'] = $unitPrice;

      // Simpan Produk
      $product = $this->mainRepository->create($payload);

      // Tentukan jumlah bahan yang digunakan untuk produk
      $ingredientQuantities = [
        'Garam' => 33.33, // Gram
        'Mentega' => 1.86, // Gram
        'Pewarna Makanan Warna Merah' => 5, // Mililiter
        'Keju' => 20, // Gram
        'Msg' => 33.3, // Gram
        'Telur' => 200, // Mililiter
        'Tepung terigu' => 1.24,  // 1.24 kg dalam kilogram
        'Tepung aci' => 0.84,  // 0.84 kg dalam kilogram
      ];

      // Loop melalui bahan-bahan dan simpan ke tabel pivot
      foreach ($ingredientQuantities as $ingredientName => $quantityUsed) {
        $material = $this->materialRepository->getWhere(
          wheres: [
            'name' => $ingredientName,
          ]
        )->first();

        if ($material) {
          $quantityUsedForProduct = $quantityUsed * $request->quantity;

          if ($quantityUsedForProduct > $material->total) {
            return redirect()->back()->with('error', 'Stok bahan tidak cukup untuk membuat produk ini. Silahkan kurangi stok tersedia untuk menambahkan produk atau tambahkan jumlah bahan baku terlebih dahulu');
          }

          $product->materials()->attach($material->id, ['quantity_used' => $quantityUsedForProduct]);
          $material->total -= $quantityUsedForProduct;
          $material->save();
        }
      }

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

      // Ambil data produk
      $product = $this->mainRepository->findOrFail($id);

      // Ambil `quantity` lama
      $oldQuantity = $product->quantity;

      $price = $request->price;
      $unitPrice = str_replace(',', '', $price);

      $payload = $request->validated();
      $payload['expired_at'] = Carbon::parse($request->produced_at)->addWeeks(1)->format('Y-m-d');
      $payload['price'] = $unitPrice;

      $this->mainRepository->update($id, $payload);

      // Tentukan jumlah bahan yang digunakan untuk produk
      $ingredientQuantities = [
        'Garam' => 33.33, // Gram
        'Mentega' => 1.86, // Gram
        'Pewarna Makanan Warna Merah' => 5, // Mililiter
        'Keju' => 20, // Gram
        'Msg' => 33.3, // Gram
        'Telur' => 200, // Mililiter
        'Tepung terigu' => 1.24,  // 1.24 kg dalam kilogram
        'Tepung aci' => 0.84,  // 0.84 kg dalam kilogram
      ];

      foreach ($ingredientQuantities as $ingredientName => $quantityUsed) {
        $material = $this->materialRepository->getWhere(
          wheres: [
            'name' => $ingredientName,
          ]
        )->first();

        if ($material) {
          $quantityUsedForProduct = $quantityUsed * $request->quantity;
          $oldQuantityUsedForProduct = $quantityUsed * $oldQuantity;

          // Hitung perbedaan stok
          $stockDifference = $oldQuantityUsedForProduct - $quantityUsedForProduct;

          if ($stockDifference > 0) {
            // Kembalikan bahan ke stok jika perbedaan positif
            $material->total += $stockDifference;
          } elseif ($stockDifference < 0) {
            // Kurangi stok bahan jika perbedaan negatif
            $material->total -= abs($stockDifference);
          }

          $material->save();

          // Hapus data lama di tabel pivot
          $product->materials()->detach($material->id);

          // Tambahkan data baru ke tabel pivot sesuai dengan `quantity` yang baru
          $product->materials()->attach($material->id, ['quantity_used' => $quantityUsedForProduct]);
        }
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }
}
