<?php

namespace App\Services\Count;

use App\Helpers\Fuzzy\Sale;
use App\Helpers\Fuzzy\Stock;
use App\Helpers\Helper;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Log;
use App\Repositories\Count\CountRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Transaction\TransactionRepository;

class CountServiceImplement extends Service implements CountService
{
  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  public function __construct(
    protected CountRepository $mainRepository,
    protected ProductRepository $productRepository,
    protected TransactionRepository $transactionRepository,
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

  public function handleCreateData($request)
  {
    try {
      DB::beginTransaction();

      $payload = $request->validated();

      $transaction = $this->transactionRepository->findOrFail($payload['transaction_id']);
      $product = $this->productRepository->findOrFail($transaction->product_id);

      $dateCreatedTransaction = Helper::parseDateTime($transaction->created_at);

      // Menentukan point variabel input
      $sale = (int) $transaction->quantity;
      $stock = (int) $product->quantity_one_day;

      // Mencari nilai drajat keanggotaan
      $persediaanSedikit = Stock::sedikit($stock);
      $persediaanSedang = Stock::sedang($stock);
      $persediaanTinggi = Stock::tinggi($stock);

      $penjualanTurun = Sale::turun($sale);
      $penjualanTetap = Sale::tetap($sale);
      $penjualanTinggi = Sale::tinggi($sale);

      // Mencari nilai alpha atau rule
      $rule1 = min($penjualanTurun, $persediaanTinggi);
      $z1 = 48 - $rule1 * (48 - 2); // Produksi Sedikit

      $rule2 = min($penjualanTurun, $persediaanSedang);
      $z2 = 48 - $rule2 * (48 - 2); // Produksi Sedikit

      $rule3 = min($penjualanTurun, $persediaanSedikit);
      $z3 = 48 - $rule3 * (48 - 2); // Produksi Sedikit

      $rule4 = min($penjualanTetap, $persediaanTinggi);
      $z4 = 48 - $rule4 * (48 - 2); // Produksi Sedikit

      $rule5 = min($penjualanTetap, $persediaanSedang);
      $z5 = 12; // Produksi Sedang

      $rule6 = min($penjualanTetap, $persediaanSedikit);
      $z6 = $rule6 * (48 - 2) + 2; // Produksi Banyak

      $rule7 = min($penjualanTinggi, $persediaanTinggi);
      $z7 = $rule7 * (48 - 2) + 2; // Produksi Banyak

      $rule8 = min($penjualanTinggi, $persediaanSedang);
      $z8 = $rule8 * (48 - 2) + 2; // Produksi Banyak

      $rule9 = min($penjualanTinggi, $persediaanSedikit);
      $z9 = $rule9 * (48 - 2) + 2; // Produksi Banyak

      $totalRule = ($rule1 * $z1) + ($rule2 * $z2) + ($rule3 * $z3) + ($rule4 * $z4) + ($rule5 * $z5) + ($rule6 * $z6) + ($rule7 * $z7) + ($rule8 * $z8) + ($rule9 * $z9);

      $totalNilaiZ = $rule1 + $rule2 + $rule3 + $rule4 + $rule5 + $rule6 + $rule7 + $rule8 + $rule9;

      $defuzzyfikasi = $totalRule / $totalNilaiZ;

      $result = ceil($defuzzyfikasi);

      // Ingredient
      // Garam 33,33 Gram
      // Mentega 1,86 Gram
      // Perwarna makanan warna merah : 5 ml
      // Keju : 20 gram
      // Msg : 33,3 gram
      // Telur : 200 ml
      // Tepung terigu : 1,24 kg
      // Tepung aci : 0,84 kg / 840 gram

      $salt = ceil(33.33 * $result);
      $butter = ceil(1.86 * $result);
      $foodColoring = ceil(5 * $result);
      $cheese = ceil(20 * $result);
      $msg = ceil(33.3 * $result);
      $egg = ceil(200 * $result);
      $flour = ceil(1.24 * $result);
      $aciFlour = ceil(0.84 * $result);

      $payload['stock'] = $stock;
      $payload['sale'] = $sale;
      $payload['score'] = $defuzzyfikasi;
      $payload['description'] = "Berdasarkan perhitungan dengan metode
      fuzzy Tsukamoto, maka pada hari {$dateCreatedTransaction} jumlah Produksi yang harus dilakukan ketika nilai penjualan sebanyak {$sale} dan nilai persediaan sebanyak {$stock} adalah sebanyak {$result} barang.";
      $payload['ingredient_description'] =
        "<span class='fw-normal'>Berdasarkan jumlah produksi yang sudah diprediksi ({$result} Produk). Maka bahan yang akan dihabiskan adalah sebagai berikut:</span>
        <div class='row my-3'>
          <div class='col-md-6'>
            <ul class='list-group push'>
              <li class='list-group-item d-flex justify-content-between align-items-center'>
                Garam
                <span class='fw-semibold'>{$salt} Gram</span>
              </li>
              <li class='list-group-item d-flex justify-content-between align-items-center'>
                Mentega
                <span class='fw-semibold'>{$butter} Gram</span>
              </li>
              <li class='list-group-item d-flex justify-content-between align-items-center'>
                Pewarna Makanan (Merah)
                <span class='fw-semibold'>{$foodColoring} Mililiter</span>
              </li>
              <li class='list-group-item d-flex justify-content-between align-items-center'>
                Keju
                <span class='fw-semibold'>{$cheese} Gram</span>
              </li>
            </ul>
          </div>
          <div class='col-md-6'>
            <ul class='list-group push'>
              <li class='list-group-item d-flex justify-content-between align-items-center'>
                MSG
                <span class='fw-semibold'>{$msg} Gram</span>
              </li>
              <li class='list-group-item d-flex justify-content-between align-items-center'>
                Telur
                <span class='fw-semibold'>{$egg} Mililiter</span>
              </li>
              <li class='list-group-item d-flex justify-content-between align-items-center'>
                Tepung Terigu
                <span class='fw-semibold'>{$flour} Kilogram</span>
              </li>
              <li class='list-group-item d-flex justify-content-between align-items-center'>
                Tepung Aci
                <span class='fw-semibold'>{$aciFlour} Kilogram</span>
              </li>
            </ul>
          </div>
        </div>
      ";

      $this->mainRepository->create($payload);

      // dd([
      //   'persediaan' => $stock,
      //   'pernjualan' => $sale,

      //   'persediaan sedikit' => $persediaanSedikit,
      //   'persediaan sedang' => $persediaanSedang,
      //   'persediaan tinggi' => $persediaanTinggi,

      //   'persediaan total' => $persediaanSedikit + $persediaanSedang + $persediaanTinggi,

      //   'penjualan turun' => $penjualanTurun,
      //   'penjualan Tetap' => $penjualanTetap,
      //   'penjualan Tinggi' => $penjualanTinggi,

      //   'penjualan total' => $penjualanTurun + $penjualanTetap + $penjualanTinggi,

      //   'rule 1' => $rule1,
      //   'rule 2' => $rule2,
      //   'rule 3' => $rule3,
      //   'rule 4' => $rule4,
      //   'rule 5' => $rule5,
      //   'rule 6' => $rule6,
      //   'rule 7' => $rule7,
      //   'rule 8' => $rule8,
      //   'rule 9' => $rule9,

      //   'z1' => $z1,
      //   'z2' => $z2,
      //   'z3' => $z3,
      //   'z4' => $z4,
      //   'z5' => $z5,
      //   'z6' => $z6,
      //   'z7' => $z7,
      //   'z8' => $z8,
      //   'z9' => $z9,

      //   'total alpha * z' => $totalRule,
      //   'total nilai alpha' => $totalNilaiZ,
      //   'defuzzyfikasi' => $defuzzyfikasi,
      // ]);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
  }
}
