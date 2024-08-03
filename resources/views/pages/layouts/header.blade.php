<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('home') }}" class="nav-link"><b>Home</b></a>
    </li>
    <!-- Navbar Search -->
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Dropdown Menu -->
    <li class="nav-item dropdown">
      {{-- <a class="nav-link user-panel d-flex" data-toggle="dropdown" href="#">
        <div class="image">
          <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" style="width: 1.4rem" alt="username">
        </div>
        <div class="info">admin</div>
      </a> --}}
      <a href="#" class="nav-link text-purple" data-toggle="dropdown">
        @if (Storage::disk('public')->exists(auth()->user()->avatar) && auth()->user()->avatar != null)
          <span><b>{{ auth()->user()->username }}</b></span><img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="img-circle elevation-1 ml-2" style="width: 2rem" alt="profile"><i class="fas fa-angle-down text-secondary ml-2"></i>
        @else
          <span><b>{{ auth()->user()->username }}</b></span><img src="{{ asset('assets/dist/img/default-avatar.png') }}" class="img-circle elevation-1 ml-2" style="width: 2rem" alt="profile"><i class="fas fa-angle-down text-secondary ml-2"></i>
        @endif
        {{-- <span><b>{{ auth()->user()->username }}</b></span><div class="avatar-circle" style="width: 2rem" alt="profile">{{ split_name(auth()->user()->name) }}</div><i class="fas fa-angle-down text-secondary ml-2"></i> --}}
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">User Menu</span>
        <div class="dropdown-divider"></div>
        <a href="{{ route('user.edit', Auth::user()->id) }}" class="dropdown-item">
          <i class="fas fa-user-cog mr-2"></i> Edit Profile
        </a>
        @if (isAccess('privilege', get_menu_id('role'), auth()->user()->role_id))
          <div class="dropdown-divider"></div>
          <a href="{{ route('role.index') }}" class="dropdown-item">
            <i class="fas fa-cog mr-2"></i> Settings & Privacy
          </a>
        @endif
        <div class="dropdown-divider"></div>
        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="fas fa-power-off mr-2"></i> Log out
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
        <div class="dropdown-divider"></div>
        <p class="dropdown-item dropdown-footer text-sm text-muted">Copyright &copy; 2023 <a target="_blank" rel="noopener noreferrer" href="https://github.com/novalalthoff">Noval Althoff</a>.</p>
      </div>
    </li>
  </ul>

  {{-- <ul class="nav nav-pills nav-sidebar" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
          {{ session()->get('name') }}
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url('logout') }}" class="nav-link">
            <i class="fas fa-power-off nav-icon"></i>
            <p>Logout</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('admin/user-role') }}" class="nav-link">
            <i class="fas fa-user-tag nav-icon"></i>
            <p>User Role</p>
          </a>
        </li>
      </ul>
    </li>
  </ul> --}}
</nav>
<!-- /.navbar -->