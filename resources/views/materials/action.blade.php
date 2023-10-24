@can('materials.edit')
<a href="{{ route('materials.edit', $uuid) }}" class="text-warning me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('page.materials.edit') }}"><i class="fa fa-sm fa-pencil"></i></a>
@endcan
@can('materials.destroy')
<a href="javascript:void(0)" data-uuid="{{ $uuid }}" class="text-danger me-1 delete-materials" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('page.materials.delete') }}"><i class="fa fa-sm fa-trash"></i></a>
@endcan

@vite('resources/js/utils/tooltip.js')
