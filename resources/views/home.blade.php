@extends('layouts.app')
@section('title', trans('page.overview.title'))
@section('hero')
<div class="content content-full">
  <h2 class="content-heading">
    {{ trans('page.overview.title') }}
    <nav class="breadcrumb push my-0">
      {{ Breadcrumbs::render('home') }}
    </nav>
  </h2>
</div>
@endsection
@section('content')
<div class="row">
  <!-- Row #1 -->
  <div class="col-6 col-xl-3">
    <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
      <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
        <div class="d-none d-sm-block">
          <i class="fa fa-shopping-bag fa-2x opacity-25"></i>
        </div>
        <div>
          <div class="fs-3 fw-semibold">{{ $items['sales'] }}</div>
          <div class="fs-sm fw-semibold text-uppercase text-muted">{{ trans('Produk Terjual') }}</div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-6 col-xl-3">
    <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
      <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
        <div class="d-none d-sm-block">
          <i class="fa fa-wallet fa-2x opacity-25"></i>
        </div>
        <div>
          <div class="fs-3 fw-semibold">{{ Helper::parseRupiahFormat($items['priceTransaction']) }}</div>
          <div class="fs-sm fw-semibold text-uppercase text-muted">{{ trans('Harga Terjual') }}</div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-6 col-xl-3">
    <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
      <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
        <div class="d-none d-sm-block">
          <i class="fa fa-folder-open fa-2x opacity-25"></i>
        </div>
        <div>
          <div class="fs-3 fw-semibold">{{ $items['stock'] }}</div>
          <div class="fs-sm fw-semibold text-uppercase text-muted">{{ trans('Produk Tersedia') }}</div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-6 col-xl-3">
    <a class="block block-rounded block-link-shadow text-end" href="javascript:void(0)">
      <div class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
        <div class="d-none d-sm-block">
          <i class="fa fa-users fa-2x opacity-25"></i>
        </div>
        <div>
          <div class="fs-3 fw-semibold">{{ $items['users'] }}</div>
          <div class="fs-sm fw-semibold text-uppercase text-muted">{{ trans('Jumlah Pengguna') }}</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Row #1 -->
</div>
@endsection
