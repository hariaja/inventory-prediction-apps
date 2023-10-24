@extends('layouts.app')
@section('title', trans('page.materials.title'))
@section('hero')
<div class="content content-full">
  <h2 class="content-heading">
    {{ trans('page.materials.title') }}
    <nav class="breadcrumb push my-0">
      {{ Breadcrumbs::render('materials.index') }}
    </nav>
  </h2>
</div>
@endsection
@section('content')
<div class="block block-rounded">
  <div class="block-header block-header-default">
    <h3 class="block-title">
      {{ trans('page.materials.index') }}
    </h3>
  </div>
  <div class="block-content">

    @can('materials.create')
    <div class="row mb-4">
      <div class="col-md-4">
        <a href="{{ route('materials.create') }}" class="btn btn-sm btn-primary">
          <i class="fa fa-plus fa-xs me-1"></i>
          {{ trans('page.materials.create') }}
        </a>
      </div>
    </div>
    @endcan

    <div class="my-3">
      {{ $dataTable->table() }}
    </div>

  </div>
</div>
@endsection
@push('javascript')
{{ $dataTable->scripts() }}
@vite('resources/js/masters/materials/index.js')
<script>
  var urlDestroy = "{{ route('materials.destroy', ':uuid') }}"

</script>
@endpush
