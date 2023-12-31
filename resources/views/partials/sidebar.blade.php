<nav id="sidebar">
  <!-- Sidebar Content -->
  <div class="sidebar-content">
    <!-- Side Header -->
    <div class="content-header justify-content-lg-center">
      <!-- Logo -->
      <div>
        <span class="smini-visible fw-bold tracking-wide fs-lg">
          c<span class="text-primary">b</span>
        </span>
        <a class="link-fx fw-bold tracking-wide mx-auto" href="{{ route('home') }}">
          <span class="smini-hidden">
            <img class="img-placeholder-center" src="{{ asset(config('commons.logo')) }}" alt="" width="100%">
          </span>
        </a>
      </div>
      <!-- END Logo -->

      <!-- Options -->
      <div>
        <!-- Close Sidebar, Visible only on mobile screens -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
        <button type="button" class="btn btn-sm btn-alt-danger d-lg-none" data-toggle="layout" data-action="sidebar_close">
          <i class="fa fa-fw fa-times"></i>
        </button>
        <!-- END Close Sidebar -->
      </div>
      <!-- END Options -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">

      <!-- Side User -->
      <div class="content-side content-side-user px-0 py-0">
        <!-- Visible only in mini mode -->
        <div class="smini-visible-block animated fadeIn px-3">
          <img class="img-avatar img-avatar32" src="{{ me()->getUserAvatar() }}" alt="">
        </div>
        <!-- END Visible only in mini mode -->

        <!-- Visible only in normal mode -->
        <div class="smini-hidden text-center mx-auto">
          <a class="img-link" href="">
            <img class="img-avatar" src="{{ me()->getUserAvatar() }}" alt="">
          </a>
          <ul class="list-inline mt-3 mb-0">
            <li class="list-inline-item">
              <a class="link-fx text-dual fs-sm fw-semibold text-uppercase" href="{{ route('users.show', me()->uuid) }}">
                {{ me()->name }}
              </a>
            </li>
            <li class="list-inline-item">
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <a class="link-fx text-dual" data-toggle="layout" data-action="dark_mode_toggle" href="javascript:void(0)">
                <i class="fa fa-burn"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a class="link-fx text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-input').submit();">
                <i class="fa fa-sign-out-alt"></i>
              </a>

              <form id="logout-input" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>
        </div>
        <!-- END Visible only in normal mode -->
      </div>
      <!-- END Side User -->

      <!-- Side Navigation -->
      <div class="content-side content-side-full">
        <ul class="nav-main">
          <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('home*') ? 'active' : '' }}" href="{{ route('home') }}">
              <i class="nav-main-link-icon fa fa-house-user"></i>
              <span class="nav-main-link-name">{{ trans('page.overview.title') }}</span>
            </a>
          </li>

          @canany(['transactions.index', 'counts.index'])
          <li class="nav-main-heading">{{ trans('Riwayat') }}</li>
          @endcan

          @can('transactions.index')
          <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('transactions*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
              <i class="nav-main-link-icon fa fa-money-bill"></i>
              <span class="nav-main-link-name">{{ trans('page.transactions.title') }}</span>
            </a>
          </li>
          @endcan

          @can('counts.index')
          <li class="nav-main-item">
            <a class="nav-main-link {{ Request::is('counts*') ? 'active' : '' }}" href="{{ route('counts.index') }}">
              <i class="nav-main-link-icon fa fa-calculator"></i>
              <span class="nav-main-link-name">{{ trans('page.counts.title') }}</span>
            </a>
          </li>
          @endcan

          @canany(['materials.index', 'products.index'])
          <li class="nav-main-heading">{{ trans('Master Data') }}</li>

          <li class="nav-main-item {{ Request::is('masters*') ? 'open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="{{ Request::is('masters*') ? 'true' : 'false' }}" href="#">
              <i class="nav-main-link-icon fa fa-folder-open"></i>
              <span class="nav-main-link-name">{{ trans('Persediaan') }}</span>
            </a>
            <ul class="nav-main-submenu">
              @can('materials.index')
              <li class="nav-main-item">
                <a class="nav-main-link {{ Request::is('masters/materials*') ? 'active' : '' }}" href="{{ route('materials.index') }}">
                  <span class="nav-main-link-name">{{ trans('page.materials.title') }}</span>
                </a>
              </li>
              @endcan
              @can('products.index')
              <li class="nav-main-item">
                <a class="nav-main-link {{ Request::is('masters/products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                  <span class="nav-main-link-name">{{ trans('page.products.title') }}</span>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan

          @canany(['roles.index', 'users.index'])
          <li class="nav-main-heading">{{ trans('Management') }}</li>

          <li class="nav-main-item {{ Request::is('settings*') ? 'open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="{{ Request::is('settings*') ? 'true' : 'false' }}" href="#">
              <i class="nav-main-link-icon fa fa-cog"></i>
              <span class="nav-main-link-name">{{ trans('Pengaturan') }}</span>
            </a>
            <ul class="nav-main-submenu">
              @can('users.index')
              <li class="nav-main-item">
                <a class="nav-main-link {{ Request::is('settings/users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                  <span class="nav-main-link-name">{{ trans('page.users.title') }}</span>
                </a>
              </li>
              @endcan
              @can('roles.index')
              <li class="nav-main-item">
                <a class="nav-main-link {{ Request::is('settings/roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                  <span class="nav-main-link-name">{{ trans('page.roles.title') }}</span>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan

        </ul>
      </div>
      <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
  </div>
  <!-- Sidebar Content -->
</nav>
