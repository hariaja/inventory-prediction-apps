@extends('layouts.app')
@section('title', trans('page.products.title'))
@section('hero')
<div class="content content-full">
  <h2 class="content-heading">
    {{ trans('page.products.title') }}
    <nav class="breadcrumb push my-0">
      {{ Breadcrumbs::render('products.create') }}
    </nav>
  </h2>
</div>
@endsection
@section('content')
<div class="block block-rounded">
  <div class="block-header block-header-default">
    <h3 class="block-title">
      {{ trans('page.products.create') }}
    </h3>
  </div>
  <div class="block-content">

    <form action="{{ route('products.store') }}" method="POST" onsubmit="return disableSubmitButton()">
      @csrf

      <div class="row justify-content-center">
        <div class="col-md-6">

          <div class="mb-4">
            <label class="form-label" for="name">{{ trans('Nama Produk') }}</label>
            <span class="text-danger">*</span>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" onkeypress="return hanyaHuruf(event)" placeholder="{{ trans('Masukan Nama Produk') }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label class="form-label" for="quantity">{{ trans('Jumlah') }}</label>
            <span class="text-danger">*</span>
            <input type="number" min="1" max="50" step="1" name="quantity" id="quantity" value="{{ old('quantity') }}" class="form-control @error('quantity') is-invalid @enderror" placeholder="{{ trans('Masukkan Jumlah') }}">
            @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="produced_at" class="form-label">{{ trans('Tanggal Produksi') }}</label>
            <span class="text-danger">*</span>
            <input type="text" class="js-flatpickr form-control @error('produced_at') is-invalid @enderror" id="produced_at" name="produced_at" min="{{ date('Y-m-d') }}" placeholder="{{ trans('Pilih Tanggal Produksi') }}" value="{{ old('produced_at') }}">
            @error('produced_at')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="description" class="form-label">{{ trans('Deskripsi Produk') }}</label>
            <span class="text-danger">
              <em>Opsional</em>
            </span>
            <textarea name="description" id="description" style="height: 130px" class="form-control @error('description') is-invalid @enderror" placeholder="{{ trans('Deskripsi Produk') }}">{{ old('description') }}</textarea>
            @error('description')
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
@vite('resources/js/masters/products/input.js')
