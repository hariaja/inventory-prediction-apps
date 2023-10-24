<?php

namespace App\Http\Controllers\Histories;

use App\DataTables\Histories\CountDataTable;
use App\Models\Count;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Histories\CountRequest;
use App\Services\Count\CountService;
use App\Services\Product\ProductService;
use App\Services\Transaction\TransactionService;
use Illuminate\Support\Carbon;

use function Termwind\render;

class CountController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    protected CountService $countService,
    protected ProductService $productService,
    protected TransactionService $transactionService,
  ) {
    // 
  }

  /**
   * Display a listing of the resource.
   */
  public function index(CountDataTable $dataTable)
  {
    return $dataTable->render('counts.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $today = Carbon::now();
    $transactions = $this->transactionService->getQuery()->whereDate('created_at', $today)->get();

    return view('counts.create', compact('transactions'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CountRequest $request)
  {
    $this->countService->handleCreateData($request);
    return redirect(route('counts.index'))->withSuccess(trans('session.create'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Count $count)
  {
    return view('counts.show', compact('count'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Count $count)
  {
    $this->countService->delete($count->id);
    return response()->json([
      'message' => trans('session.delete')
    ]);
  }
}
