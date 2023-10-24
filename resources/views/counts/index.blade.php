@extends('layouts.app')
@section('title', trans('page.counts.title'))
@section('hero')
<div class="content content-full">
  <h2 class="content-heading">
    {{ trans('page.counts.title') }}
    <nav class="breadcrumb push my-0">
      {{ Breadcrumbs::render('counts.index') }}
    </nav>
  </h2>
</div>
@endsection
@section('content')
<div class="block block-rounded">
  <div class="block-header block-header-default">
    <h3 class="block-title">
      {{ trans('page.counts.index') }}
    </h3>
  </div>
  <div class="block-content">

    @can('counts.create')
    <div class="row mb-4">
      <div class="col-md-4">
        <a href="{{ route('counts.create') }}" class="btn btn-sm btn-primary">
          <i class="fa fa-plus fa-xs me-1"></i>
          {{ trans('page.counts.create') }}
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
@vite('resources/js/counts/index.js')
<script>
  var urlDestroy = "{{ route('counts.destroy', ':uuid') }}"

</script>
@endpush
