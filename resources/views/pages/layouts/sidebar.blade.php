<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-purple elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <div class="brand-image mt-1"><i class="fas fa-capsules text-pink"></i></div> <div class="brand-text font-weight-light"><b>Drug</b>Vault</div>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        {{-- <img src="{{ url('') }}/assets/dist/img/althoff.png" class="img-circle elevation-2" alt="User Image"> --}}
        <div class="avatar-circle elevation-2" alt="User's Avatar">{{ split_name(auth()->user()->name) }}</div>
      </div>
      <div class="info">
        <a href="#" class="d-block">Ola, <b>{{ auth()->user()->username }}</b> !</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

        @foreach ($parent_menu as $pm)
          @php
            $role_access = isAccess('list', $pm->id_menu, Auth::user()->role_id);
            if (!$role_access) { continue; }
          @endphp
          <li class="nav-item">
            @if ($pm->link_menu == '#')
              <a href="#" class="nav-link">
            @else
              <a href="{{ url($pm->link_menu) }}" class="nav-link">
            @endif
              <i class="nav-icon {{ $pm->icon_menu }}"></i>
              <p>
                {{ $pm->name_menu }}
                @if (count($pm->menus) > 0)
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge bg-pink right">{{ count($pm->menus) }}</span>
                @endif
              </p>
            </a>
            @if (count($pm->menus) > 0)
              <ul class="nav nav-treeview">
                @foreach ($pm->menus as $sm)
                  @php
                    $role_access = isAccess('list', $sm->id_menu, Auth::user()->role_id);
                    if (!$role_access) { continue; }
                  @endphp
                  <li class="nav-item">
                    <a href="{{ url($sm->link_menu) }}" class="nav-link">
                      <i class="fas {{ $sm->icon_menu }} nav-icon"></i>
                      <p>{{ $sm->name_menu }}</p>
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif
          </li>
        @endforeach

        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-power-off"></i>
            <p>
              Logout
            </p>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>