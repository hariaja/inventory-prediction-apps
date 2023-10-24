@can('products.edit')
<a href="{{ route('products.edit', $uuid) }}" class="text-warning me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('page.products.edit') }}"><i class="fa fa-sm fa-pencil"></i></a>
@endcan
@can('products.show')
<a href="javascript:void(0)" data-uuid="{{ $uuid }}" class="text-modern me-1 show-products" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('page.products.show') }}"><i class="fa fa-sm fa-eye"></i></a>
@endcan
@can('products.destroy')
<a href="javascript:void(0)" data-uuid="{{ $uuid }}" class="text-danger me-1 delete-products" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('page.products.delete') }}"><i class="fa fa-sm fa-trash"></i></a>
@endcan

@vite('resources/js/utils/tooltip.js')
