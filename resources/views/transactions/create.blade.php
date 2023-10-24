@extends('layouts.app')
@section('title', trans('page.transactions.title'))
@section('hero')
<div class="content content-full">
  <div class="content-heading">
    <div class="d-flex justify-content-between align-items-sm-center">
      {{ trans('page.transactions.title') }}
      <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-block-option text-danger">
        <i class="fa fa-xs fa-chevron-left me-1"></i>
        {{ trans('button.back') }}
      </a>
    </div>
    <nav class="breadcrumb push my-0">
      {{ Breadcrumbs::render('transactions.create') }}
    </nav>
  </div>
</div>
@endsection
@section('content')
<div class="block block-rounded">
  <div class="block-header block-header-default">
    <h3 class="block-title">
      {{ trans('page.transactions.create') }}
    </h3>
  </div>
  <div class="block-content">

    <form action="{{ route('transactions.store') }}" method="POST" onsubmit="return disableSubmitButton()">
      @csrf

      <div class="row justify-content-center">
        <div class="col-md-6">

          <div class="mb-4">
            <label for="product_id" class="form-label">{{ trans('Produk') }}</label>
            <span class="text-danger">*</span>
            <select name="product_id" id="product_id" class="js-select2 form-select @error('product_id') is-invalid @enderror" data-placeholder="{{ trans('Pilih Produk') }}" style="width: 100%;">
              <option></option>
              @foreach ($products as $item)
              <option value="{{ $item->id }}" data-uuid="{{ $item->uuid }}" @if (old('product_id')==$item->id) selected @endif>{{ $item->name }}</option>
              @endforeach
            </select>
            @error('product_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4" style="display: none;" id="product-detail">
            <div class="mb-4">
              <strong>{{ trans('Detail Informasi Produk') }}</strong>
              <br>
              <span class="text-muted">{{ trans('Silahkan pilih produk untuk menampilkan data') }}</span>
            </div>
            <ul class="list-group push">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ trans('Kode Produk') }}
                <span class="fw-semibold" id="product-code"></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ trans('Nama Produk') }}
                <span class="fw-semibold" id="product-name"></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ trans('Stok Tersedia') }}
                <span class="fw-semibold" id="product-quantity"></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ trans('Harga Satuan') }}
                <span class="fw-semibold" id="product-price"></span>
              </li>
            </ul>
          </div>

          <div class="mb-4">
            <label class="form-label" for="quantity">{{ trans('Jumlah Terjual') }}</label>
            <span class="text-danger">*</span>
            <input type="number" min="1" max="25" step="1" name="quantity" id="quantity" value="{{ old('quantity') }}" class="form-control @error('quantity') is-invalid @enderror" placeholder="{{ trans('Masukkan Jumlah') }}">
            @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-1">
            <button type="reset" class="btn btn-danger w-100">
              <i class="fa fa-fw fa-eraser me-1"></i>
              {{ trans('Reset') }}
            </button>
          </div>
          <div class="mb-4">
            <button type="submit" class="btn btn-primary w-100" id="submit-button">
              <i class="fa fa-fw fa-circle-check me-1"></i>
              {{ trans('button.create') }}
            </button>
          </div>

        </div>
      </div>

    </form>

  </div>
</div>
@endsection
@push('javascript')
<script>
  var urlShowDetail = "{{ route('products.show', ':uuid') }}"

</script>
@endpush
@vite('resources/js/transactions/input.js')
