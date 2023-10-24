@can('counts.show')
<a href="{{ route('counts.show', $uuid) }}" class="text-info me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('page.counts.show') }}"><i class="fa fa-sm fa-eye"></i></a>
@endcan
@can('counts.destroy')
<a href="javascript:void(0)" data-uuid="{{ $uuid }}" class="text-danger me-1 delete-counts" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ trans('page.counts.delete') }}"><i class="fa fa-sm fa-trash"></i></a>
@endcan

@vite('resources/js/utils/tooltip.js')
