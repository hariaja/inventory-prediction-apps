<?php

namespace App\Http\Controllers;

use App\Services\Product\ProductService;
use App\Services\Transaction\TransactionService;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    protected ProductService $productService,
    protected TransactionService $transactionService,
    protected UserService $userService,
  ) {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $productStock = $this->productService->getQuery()->sum('quantity');
    $saleProduct = $this->transactionService->getQuery()->sum('quantity');
    $priceTransaction = $this->transactionService->getQuery()->sum('price');
    $users = $this->userService->getQuery()->count();

    $items = [
      'sales' => $saleProduct,
      'stock' => $productStock,
      'priceTransaction' => $priceTransaction,
      'users' => $users,
    ];

    return view('home', compact('items'));
  }
}
