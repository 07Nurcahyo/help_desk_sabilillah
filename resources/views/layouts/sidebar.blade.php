    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }} | {{ Auth::user()->role }}</a>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          @if ( Auth::user()->role == 'admin' )
            <li class="nav-item">
              <a href="{{ url('/admin') }}" class="nav-link {{ ($activeMenu == 'dashboard')? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('user/kelola_laporan_admin') }}" class="nav-link {{ ($activeMenu == 'kelola_laporan_admin')? 'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                  Kelola Laporan
                </p>
              </a>
            </li>

          @else
            <li class="nav-item">
              <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'rekap_laporan')? 'active' : '' }}">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                  Rekap Laporan
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ url('user/kelola_laporan') }}" class="nav-link {{ ($activeMenu == 'kelola_laporan')? 'active' : '' }}">
                <i class="nav-icon fas fa-tools"></i>    <p>
                  Kelola Laporan
                </p>
              </a>
            </li>
          @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>