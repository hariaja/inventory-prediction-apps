<?php

namespace App\DataTables\Histories;

use App\Models\Count;
use App\Helpers\Helper;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Services\Count\CountService;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class CountDataTable extends DataTable
{
  /**
   * Create a new database instance.
   *
   * @return void
   */
  public function __construct(
    protected CountService $countService,
  ) {
    // 
  }

  /**
   * Build the DataTable class.
   *
   * @param QueryBuilder $query Results from query() method.
   */
  public function dataTable(QueryBuilder $query): EloquentDataTable
  {
    return (new EloquentDataTable($query))
      ->addIndexColumn()
      ->addColumn('product_name', fn ($row) => $row->transaction->product->name)
      ->addColumn('product_stock', fn ($row) => "{$row->transaction->product->quantity_one_day} Per Hari")
      ->addColumn('transaction', fn ($row) => "{$row->transaction->quantity} Per Hari")
      ->addColumn('prediction', fn ($row) => ceil($row->score) . " Produk")
      ->addColumn('action', 'counts.action')
      ->rawColumns([
        'action'
      ]);
  }

  /**
   * Get the query source of dataTable.
   */
  public function query(Count $model): QueryBuilder
  {
    return $this->countService->getQuery()->latest();
  }

  /**
   * Optional method if you want to use the html builder.
   */
  public function html(): HtmlBuilder
  {
    return $this->builder()
      ->setTableId('count-table')
      ->columns($this->getColumns())
      ->minifiedAjax()
      //->dom('Bfrtip')
      ->addTableClass([
        'table',
        'table-striped',
        'table-bordered',
        'table-hover',
        'table-vcenter',
      ])
      ->processing(true)
      ->retrieve(true)
      ->serverSide(true)
      ->autoWidth(false)
      ->pageLength(5)
      ->responsive(true)
      ->lengthMenu([5, 10, 20])
      ->orderBy(1);
  }

  /**
   * Get the dataTable columns definition.
   */
  public function getColumns(): array
  {
    // Check Visibility of Action Row
    $visibility = Helper::checkPermissions([
      'counts.edit',
      'counts.destroy',
    ]);

    return [
      Column::make('DT_RowIndex')
        ->title(trans('#'))
        ->orderable(false)
        ->searchable(false)
        ->width('5%')
        ->addClass('text-center'),
      Column::make('product_name')
        ->title(trans('Nama Produk'))
        ->addClass('text-center'),
      Column::make('product_stock')
        ->title(trans('Stok'))
        ->addClass('text-center'),
      Column::make('transaction')
        ->title(trans('Transaksi'))
        ->addClass('text-center'),
      Column::make('score')
        ->title(trans('Nilai Fuzzy'))
        ->addClass('text-center'),
      Column::make('prediction')
        ->title(trans('Perkiraan Produksi Barang'))
        ->addClass('text-center'),
      Column::computed('action')
        ->exportable(false)
        ->printable(false)
        ->visible($visibility)
        ->width('10%')
        ->addClass('text-center'),
    ];
  }

  /**
   * Get the filename for export.
   */
  protected function filename(): string
  {
    return 'Count_' . date('YmdHis');
  }
}
