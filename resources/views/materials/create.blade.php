@extends('layouts.app')
@section('title', trans('page.materials.title'))
@section('hero')
<div class="content content-full">
  <h2 class="content-heading">
    {{ trans('page.materials.title') }}
    <nav class="breadcrumb push my-0">
      {{ Breadcrumbs::render('materials.create') }}
    </nav>
  </h2>
</div>
@endsection
@section('content')
<div class="block block-rounded">
  <div class="block-header block-header-default">
    <h3 class="block-title">
      {{ trans('page.materials.create') }}
    </h3>
  </div>
  <div class="block-content">

    <form action="{{ route('materials.store') }}" method="POST" onsubmit="return disableSubmitButton()">
      @csrf

      <div class="row justify-content-center">
        <div class="col-md-6">

          <div class="mb-4">
            <label class="form-label" for="name">{{ trans('Nama Bahan') }}</label>
            <span class="text-danger">*</span>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" onkeypress="return hanyaHuruf(event)">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label class="form-label" for="total">{{ trans('Jumlah') }}</label>
            <span class="text-danger">*</span>
            <input type="number" min="1" max="100" step="1" name="total" id="total" value="{{ old('total') }}" class="form-control @error('total') is-invalid @enderror">
            @error('total')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="mass" class="form-label">{{ trans('Massa Berat') }}</label>
            <span class="text-danger">*</span>
            <select name="mass" id="mass" class="js-select2 form-select @error('mass') is-invalid @enderror" data-placeholder="{{ trans('Pilih Massa Berat') }}" style="width: 100%;">
              <option></option>
              @foreach ($massTypes as $item)
              <option value="{{ $item }}">{{ $item }}</option>
              @endforeach
            </select>
            @error('mass')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
@vite('resources/js/masters/materials/input.js')
