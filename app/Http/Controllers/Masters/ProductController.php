<?php

namespace App\Http\Controllers\Masters;

use App\DataTables\Masters\ProductDataTable;
use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\ProductRequest;
use App\Services\Product\ProductService;

class ProductController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    protected ProductService $productService,
  ) {
    // 
  }

  /**
   * Display a listing of the resource.
   */
  public function index(ProductDataTable $dataTable)
  {
    return $dataTable->render('products.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('products.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ProductRequest $request)
  {
    $this->productService->handleStoreData($request);
    return redirect(route('products.index'))->withSuccess(trans('session.create'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Product $product)
  {
    $product->expired_date = Helper::parseDateTime($product->expired_at);
    $product->produced_date = Helper::parseDateTime($product->produced_at);
    $product->unit_price = Helper::parseRupiahFormat($product->price);

    return response()->json([
      'product' => $product,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Product $product)
  {
    return view('products.edit', compact('product'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ProductRequest $request, Product $product)
  {
    $this->productService->handleUpdateData($request, $product->id);
    return redirect(route('products.index'))->withSuccess(trans('session.update'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Product $product)
  {
    $this->productService->delete($product->id);
    return response()->json([
      'message' => trans('session.delete'),
    ]);
  }
}
