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
      $z5 = 12;

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

      $payload['score'] = $defuzzyfikasi;
      $payload['description'] = "Berdasarkan perhitungan dengan metode
      fuzzy Tsukamoto, maka pada tanggal {$dateCreatedTransaction} jumlah Produksi yang harus dilakukan ketika nilai penjualan sebanyak {$sale} dan nilai persediaan sebanyak {$stock} adalah sebanyak {$result} barang.";

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
