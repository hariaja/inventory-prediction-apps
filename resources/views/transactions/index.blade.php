@extends('layouts.app')
@section('title', trans('page.transactions.title'))
@section('hero')
<div class="content content-full">
  <h2 class="content-heading">
    {{ trans('page.transactions.title') }}
    <nav class="breadcrumb push my-0">
      {{ Breadcrumbs::render('transactions.index') }}
    </nav>
  </h2>
</div>
@endsection
@section('content')
<div class="block block-rounded">
  <div class="block-header block-header-default">
    <h3 class="block-title">
      {{ trans('page.transactions.index') }}
    </h3>
  </div>
  <div class="block-content">

    @can('transactions.create')
    <div class="row mb-4">
      <div class="col-md-4">
        <a href="{{ route('transactions.create') }}" class="btn btn-sm btn-primary">
          <i class="fa fa-plus fa-xs me-1"></i>
          {{ trans('page.transactions.create') }}
        </a>
      </div>
    </div>
    @endcan

    <div class="my-3">
      {{ $dataTable->table() }}
    </div>

  </div>
</div>

@includeIf('transactions.show')
@endsection
@push('javascript')
{{ $dataTable->scripts() }}
@vite('resources/js/transactions/index.js')
<script>
  var urlDestroy = "{{ route('transactions.destroy', ':uuid') }}"
  var urlShowDetail = "{{ route('transactions.show', ':uuid') }}"

</script>
@endpush
