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
      {{ Breadcrumbs::render('counts.show', $count) }}
    </nav>
  </div>
</div>
@endsection
@section('content')
<div class="block block-rounded">
  <div class="block-header block-header-default">
    <h3 class="block-title">
      {{ trans('page.counts.show') }}
    </h3>
  </div>
  <div class="block-content">

    <div class="row justify-content-center">
      <div class="col-md-6">
        <ul class="list-group push">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Kode Transaksi') }}
            <span class="fw-semibold">{{ $count->transaction->code }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Nama Produk') }}
            <span class="fw-semibold">{{ $count->transaction->product->name }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Tanggal Penjualan') }}
            <span class="fw-semibold">{{ Helper::parseDateTime($count->transaction->created_at) }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Jumlah Penjualan') }}
            <span class="fw-semibold">{{ $count->transaction->quantity . " Barang" }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Stok Persediaan Barang') }}
            <span class="fw-semibold">{{ $count->transaction->product->quantity_one_day }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Pelaku Transaksi') }}
            <span class="fw-semibold">{{ $count->transaction->user->name }}</span>
          </li>
        </ul>
      </div>
      <div class="col-md-6">
        <ul class="list-group push">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ trans('Skor Penentuan Fuzzy') }}
            <span class="fw-semibold">{{ $count->score }}</span>
          </li>
          <li class="list-group-item">
            {{ trans('Keterangan') }}
            <p class="fw-semibold mb-0" style="text-align: justify">{{ $count->description }}</p>
          </li>
        </ul>
      </div>
    </div>

  </div>
</div>
@endsection
