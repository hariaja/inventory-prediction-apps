@extends('layouts.app')
@section('title', trans('page.users.show'))
@section('hero')
<!-- User Info -->
<div class="bg-image bg-image-top" style="background-image: url({{ asset('assets/images/bg/bg-profile.png') }});">
  <div class="bg-black-75 py-4">
    <div class="content content-full text-center">
      <!-- Avatar -->
      <div class="mb-3">
        <a class="img-link" href="{{ route('users.show', $user->uuid) }}">
          <img class="img-avatar img-avatar96 img-avatar-thumb" src="{{ $user->getUserAvatar() }}" alt="">
        </a>
      </div>
      <!-- END Avatar -->

      <!-- Personal -->
      <h1 class="h3 text-white fw-bold mb-2">{{ $user->name }}</h1>
      <h2 class="h5 text-white-75">
        {{ $user->getRoleName() }}
      </h2>
      <!-- END Personal -->

      <!-- Actions -->
      <a href="{{ route('home') }}" class="btn btn-primary">
        <i class="fa fa-arrow-left fa-sm opacity-50 me-2"></i>
        {{ trans('Kembali ke Beranda') }}
      </a>
      <!-- END Actions -->
    </div>
  </div>
</div>
<!-- END User Info -->
@endsection
@section('content')
<div class="block block-rounded">
  <div class="block-header block-header-default">
    <h3 class="block-title">
      <i class="fa fa-user-circle me-2 text-muted"></i>
      {{ trans('page.users.show') }}
    </h3>
  </div>
  <div class="block-content">

    <form action="{{ route('users.update', $user->uuid) }}" method="POST" enctype="multipart/form-data" onsubmit="return disableSubmitButton()">
      @csrf
      @method('PATCH')

      <input type="hidden" value="{{ $user->getRoleName() }}" name="roles">

      <div class="row items-push">
        <div class="col-lg-3">
          <p class="text-muted">
            {{ trans('Info penting akun Anda. Nama pengguna Anda akan terlihat oleh publik.') }}
          </p>
        </div>
        <div class="col-lg-7 offset-lg-1">

          <input type="hidden" name="roles" value="{{ $user->getRoleId() }}">

          <div class="mb-4">
            <label class="form-label" for="name">{{ trans('Nama') }}</label>
            <span class="text-danger">*</span>
            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" placeholder="{{ trans('Masukkan nama anda') }}" value="{{ old('name', $user->name) }}" onkeypress="return onlyLetter(event)">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label class="form-label" for="email">{{ trans('Email') }}</label>
            <span class="text-danger">*</span>
            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ trans('Masukkan alamat email') }}" value="{{ old('email', $user->email) }}" readonly>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row mb-1">
            <div class="col-md-10 col-xl-6">
              <div class="push">
                <img class="img-avatar img-prev" src="{{ $user->getUserAvatar() }}" alt="">
              </div>
              <div class="mb-4">
                <label class="form-label" for="image" class="form-label">{{ trans('Pilih Avatar Baru') }}</label>
                <input class="form-control" type="file" id="image" name="file" accept="image/*" onchange="return previewImage()">
              </div>
            </div>
          </div>

          <div class="mb-4">
            <button type="submit" class="btn btn-alt-warning" id="submit-button">
              <i class="fa fa-fw fa-circle-check opacity-50 me-1"></i>
              {{ trans('button.edit') }}
            </button>
          </div>

        </div>
      </div>
    </form>

  </div>
</div>
@endsection
