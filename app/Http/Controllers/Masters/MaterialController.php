<?php

namespace App\Http\Controllers\Masters;

use App\DataTables\Masters\MaterialDataTable;
use App\Helpers\Enums\MassType;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\MaterialRequest;
use App\Services\Material\MaterialService;

class MaterialController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    protected MaterialService $materialService,
  ) {
    // 
  }

  /**
   * Display a listing of the resource.
   */
  public function index(MaterialDataTable $dataTable)
  {
    return $dataTable->render('materials.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $massTypes = MassType::toArray();
    return view('materials.create', compact('massTypes'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(MaterialRequest $request)
  {
    $this->materialService->handleStoreData($request);
    return redirect(route('materials.index'))->withSuccess(trans('session.create'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Material $material)
  {
    $massTypes = MassType::toArray();
    return view('materials.edit', compact('massTypes', 'material'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(MaterialRequest $request, Material $material)
  {
    $this->materialService->update($material->id, $request->validated());
    return redirect(route('materials.index'))->withSuccess(trans('session.update'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Material $material)
  {
    $this->materialService->delete($material->id);
    return response()->json([
      'message' => trans('session.delete'),
    ]);
  }
}
