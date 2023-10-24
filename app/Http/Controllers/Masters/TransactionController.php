<?php

namespace App\Http\Controllers\Masters;

use App\DataTables\Masters\TransactionDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\TransactionRequest;
use App\Models\Transaction;
use App\Services\Product\ProductService;
use App\Services\Transaction\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    protected ProductService $productService,
    protected TransactionService $transactionService,
  ) {
    // 
  }

  /**
   * Display a listing of the resource.
   */
  public function index(TransactionDataTable $dataTable)
  {
    return $dataTable->render('transactions.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $products = $this->productService->getWhere(
      wheres: [
        'quantity' => 0,
      ],
      columns: '*',
      comparisons: '>'
    )->get();

    return view('transactions.create', compact('products'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(TransactionRequest $request)
  {
    $this->transactionService->handleStoreData($request);
    return redirect(route('transactions.index'))->withSuccess(trans('session.create'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Transaction $transaction)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Transaction $transaction)
  {
    $products = $this->productService->getWhere(
      wheres: [
        'quantity' => 0,
      ],
      columns: '*',
      comparisons: '>'
    )->get();

    return view('transactions.edit', compact('products', 'transaction'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(TransactionRequest $request, Transaction $transaction)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Transaction $transaction)
  {
    $this->transactionService->handleDeleteData($transaction->id);
    return response()->json([
      'message' => trans('session.delete'),
    ]);
  }
}
