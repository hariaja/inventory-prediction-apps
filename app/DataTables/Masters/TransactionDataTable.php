<?php

namespace App\DataTables\Masters;

use App\Helpers\Helper;
use App\Models\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Services\Transaction\TransactionService;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class TransactionDataTable extends DataTable
{
  /**
   * Create a new database instance.
   *
   * @return void
   */
  public function __construct(
    protected TransactionService $transactionService,
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
      ->editColumn('name', fn ($row) => $row->product->name)
      ->editColumn('quantity', fn ($row) => "{$row->quantity} Produk")
      ->editColumn('price', fn ($row) => Helper::parseRupiahFormat($row->price))
      ->editColumn('created_at', fn ($row) => Helper::parseDateTime($row->created_at))
      ->addColumn('action', 'transactions.action')
      ->rawColumns([
        'action',
      ]);
  }

  /**
   * Get the query source of dataTable.
   */
  public function query(Transaction $model): QueryBuilder
  {
    return $this->transactionService->getQuery()->oldest('code');
  }

  /**
   * Optional method if you want to use the html builder.
   */
  public function html(): HtmlBuilder
  {
    return $this->builder()
      ->setTableId('transaction-table')
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
      'transactions.destroy',
    ]);

    return [
      Column::make('DT_RowIndex')
        ->title(trans('#'))
        ->orderable(false)
        ->searchable(false)
        ->width('5%')
        ->addClass('text-center'),
      Column::make('code')
        ->title(trans('Kode'))
        ->addClass('text-center'),
      Column::make('name')
        ->title(trans('Nama Product'))
        ->addClass('text-center'),
      Column::make('price')
        ->title(trans('Harga Total'))
        ->addClass('text-center'),
      Column::make('quantity')
        ->title(trans('Terjual'))
        ->addClass('text-center'),
      Column::make('created_at')
        ->title(trans('Tanggal Terjual'))
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
    return 'Transaction_' . date('YmdHis');
  }
}
