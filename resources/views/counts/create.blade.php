@extends('layouts.app')
@section('title', trans('page.counts.title'))
@section('hero')
<div class="content content-full">
  <div class="content-heading">
    <div class="d-flex justify-content-between align-items-sm-center">
      {{ trans('page.counts.title') }}
      <a href="{{ route('counts.index') }}" class="btn btn-sm btn-block-option text-danger">
        <i class="fa fa-xs fa-chevron-left me-1"></i>
        {{ trans('button.back') }}
      </a>
    </div>
    <nav class="breadcrumb push my-0">
      {{ Breadcrumbs::render('counts.create') }}
    </nav>
  </div>
</div>
@endsection
@section('content')
<div class="block block-rounded">
  <div class="block-header block-header-default">
    <h3 class="block-title">
      {{ trans('page.counts.create') }}
    </h3>
  </div>
  <div class="block-content">

    <form action="{{ route('counts.store') }}" method="POST" onsubmit="return disableSubmitButton()">
      @csrf

      <div class="row justify-content-center">
        <div class="col-md-6">

          <div class="mb-4">
            <div class="alert alert-warning d-flex align-items-center" role="alert">
              <i class="fa fa-fw fa-exclamation-triangle me-3"></i>
              <p class="mb-0">
                {{ trans("Perhitungan ini dilakukan dalam satu hari. Melakukan perhitungan antara data transaksi atau penjualan pada hari ini dibandingkan ke data persediaan produk per harinya. Sehingga diharapkan dapat membantu dalam memprediksi jumlah produksi perharinya sehingga meminimalisir overload dari jumlah produksi seperti yang sudah terjadi selama ini.") }}
              </p>
            </div>
          </div>

          <div class="mb-4">
            <label for="transaction_id" class="form-label">{{ trans('Transaksi') }}</label>
            <span class="text-danger">*</span>
            <select name="transaction_id" id="transaction_id" class="js-select2 form-select @error('transaction_id') is-invalid @enderror" data-placeholder="{{ trans('Pilih Transaksi') }}" style="width: 100%;">
              <option></option>
              @foreach ($transactions as $item)
              <option value="{{ $item->id }}" data-uuid="{{ $item->uuid }}" @if (old('transaction_id')==$item->id) selected @endif>{{ $item->code }}</option>
              @endforeach
            </select>
            @error('transaction_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4" style="display: none;" id="transaction-detail">
            <div class="mb-4">
              <strong>{{ trans('Detail Informasi Penjualan') }}</strong>
              <br>
              <span class="text-muted">{{ trans('Silahkan pilih Penjualan untuk menampilkan data') }}</span>
            </div>
            <ul class="list-group push">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ trans('Kode Transaksi') }}
                <span class="fw-semibold" id="transaction-code"></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ trans('Nama Produk') }}
                <span class="fw-semibold" id="product-name"></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ trans('Stok Per Hari') }}
                <span class="fw-semibold" id="product-quantity-one-day"></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ trans('Terjual Hari Ini') }}
                <span class="fw-semibold" id="transaction-success"></span>
              </li>
            </ul>
          </div>

          <div class="mb-4">
            <button type="submit" class="btn btn-primary w-100" id="submit-button">
              <i class="fa fa-fw fa-circle-check me-1"></i>
              {{ trans('Lakukan Perhitungan') }}
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
  var urlShowDetail = "{{ route('transactions.show', ':uuid') }}"

</script>
@endpush
@vite('resources/js/counts/input.js')
