<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title') - {{ config('app.name') }}</title>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Icons -->
  @include('components.logos')
  <!-- END Icons -->

  <!-- Stylesheets -->
  <!-- Codebase framework -->
  <link rel="stylesheet" href="{{ asset('assets/custom/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/template/src/js/plugins/flatpickr/flatpickr.min.css') }}">
  <link rel="stylesheet" id="css-main" href="{{ asset('assets/template/src/css/codebase.min.css') }}">
  <!-- END Stylesheets -->

  <!-- Vite Builder -->
  @vite([])
</head>
<body>
  <div id="page-container" class="main-content-boxed">
    <main id="main-container">
      @yield('content')
    </main>
  </div>

  <!-- JS -->
  <script src="{{ asset('assets/template/src/js/codebase.app.min.js') }}"></script>
  <script src="{{ asset('assets/custom/js/custom.js') }}"></script>
  <script src="{{ asset('assets/template/src/js/lib/jquery.min.js') }}"></script>

  <script src="{{ asset('assets/template/src/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

  <script>
    Codebase.helpersOnLoad([
      'js-flatpickr'
    ])

  </script>

  @include('sweetalert::alert')
</body>
</html>
