@can('transactions.show')
<a href="javascript:void(0)" data-uuid="{{ $uuid }}" class="text-modern me-1 show-transactions" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('page.transactions.show') }}"><i class="fa fa-sm fa-eye"></i></a>
@endcan
@can('transactions.destroy')
<a href="javascript:void(0)" data-uuid="{{ $uuid }}" class="text-danger me-1 delete-transactions" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('page.transactions.delete') }}"><i class="fa fa-sm fa-trash"></i></a>
@endcan

@vite('resources/js/utils/tooltip.js')
