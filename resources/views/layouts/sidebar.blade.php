    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        {{-- <div class="image">
          <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div> --}}
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }} | {{ Auth::user()->role }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          @if ( Auth::user()->role == 'admin' )
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  User
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
          @endif

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

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>