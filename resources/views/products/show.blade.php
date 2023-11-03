@extends('layouts.app')
@section('title', trans('page.products.title'))
@section('hero')
<div class="content content-full">
  <div class="content-heading">
    <div class="d-flex justify-content-between align-items-sm-center">
      {{ trans('page.products.title') }}
      <a href="{{ route('products.index') }}" class="btn btn-sm btn-block-option text-danger">
        <i class="fa fa-xs fa-chevron-left me-1"></i>
        {{ trans('button.back') }}
      </a>
    </div>
    <nav class="breadcrumb push my-0">
      {{ Breadcrumbs::render('products.show', $product) }}
    </nav>
  </div>
</div>
@endsection
@section('content')
<div class="block block-rounded">
  <div class="block-header block-header-default">
    <h3 class="block-title">
      {{ trans('page.products.show') }}
    </h3>
  </div>
  <div class="block-content">

    <div class="row justify-content-center">
      <div class="col-md-6">
        <ul class="list-group push">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Kode Produk') }}
            <span class="fw-semibold">{{ $product->code }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Nama Produk') }}
            <span class="fw-semibold">{{ $product->name }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Stok Tersedia') }}
            <span class="fw-semibold">{{ "{$product->quantity} Pcs" }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Stok Perhari') }}
            <span class="fw-semibold">{{ "{$product->quantity_one_day} Pcs" }}</span>
          </li>
        </ul>
      </div>
      <div class="col-md-6">
        <ul class="list-group push">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Harga Jual') }}
            <span class="fw-semibold">{{ Helper::parseRupiahFormat($product->price) }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Tanggal Produksi') }}
            <span class="fw-semibold">{{ Helper::parseDateTime($product->produced_at) }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Tanggal Kadaluarsa') }}
            <span class="fw-semibold">{{ Helper::parseDateTime($product->expired_at) }}</span>
          </li>
          <li class="list-group-item">
            {{ trans('Deskripsi') }}
            <p class="mb-0 fw-semibold" style="text-align: justify">{{ $product->description }}</p>
          </li>
        </ul>
      </div>
    </div>

    <div class="">
      <p>
        {{ trans("Data Persediaan Bahan Yang Dihabiskan untuk membuat {$product->quantity} adalah sebagai berikut:") }}
      </p>

      <div class="table-responsive">
        <table class="table table-striped table-vcenter text-center">
          <thead>
            <tr>
              <th>{{ trans('Nama Bahan') }}</th>
              <th>{{ trans('Jumlah Dihabiskan') }}</th>
            </tr>
          </thead>
          @foreach ($product->materials as $data)
          <tbody>
            <tr>
              <td>{{ $data->name }}</td>
              <td>{{ "{$data->pivot->quantity_used} {$data->mass}" }}</td>
            </tr>
          </tbody>
          @endforeach
        </table>
      </div>
    </div>

  </div>
</div>
@endsection
