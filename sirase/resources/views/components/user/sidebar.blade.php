<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard "
            target="_blank">
            {{-- <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo"> --}}
            <span class="ms-1 text-sm text-dark">Sirase</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @can('role:Mahasiswa')
            <li class="nav-item">
                <a class="nav-link {{ request()->is('/dashboardMahasiswa') || request()->is('dashboardMahasiswa') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ url('/dashboardMahasiswa') }}">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            @endcan
            @can('role:StaffUnit')
            <li class="nav-item">
                <a class="nav-link {{ request()->is('/dashboardStaffUnit') || request()->is('dashboardStaffUnit') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ url('/dashboardStaffUnit') }}">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            @endcan
            @can('role:AdminUnit')
            <li class="nav-item">
                <a class="nav-link {{ request()->is('/dashboardAdminUnit') || request()->is('dashboardAdminUnit') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ url('/dashboardAdminUnit') }}">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            @endcan
            @can('role:SuperAdmin')
            <li class="nav-item">
                <a class="nav-link {{ request()->is('/dashboard') || request()->is('dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ url('/dashboard') }}">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            @endcan
            @can('role:SuperAdmin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('users*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('users.index') }}">
                        <i class="material-symbols-rounded opacity-5">person_4</i>
                        <span class="nav-link-text ms-1">Master User</span>
                    </a>
                </li>
            @endcan
            @can('role:SuperAdmin')
            <li class="nav-item">
                <a class="nav-link {{ request()->is('units*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('units.index') }}">
                    <i class="material-symbols-rounded opacity-5">corporate_fare</i>
                    <span class="nav-link-text ms-1">Master Unit</span>
                </a>
            </li>
            @endcan
            @can('role:SuperAdmin')
            <li class="nav-item">
                <a class="nav-link {{ request()->is('staffUnits*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('staff.index') }}">
                    <i class="material-symbols-rounded opacity-5">badge</i>
                    <span class="nav-link-text ms-1">Master Staff Unit</span>
                </a>
            </li>
            @endcan
            @can('role:SuperAdmin')
            <li class="nav-item">
                <a class="nav-link {{ request()->is('mahasiswas*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                    href="{{ route('mahasiswa.index') }}">
                    <i class="material-symbols-rounded opacity-5">school</i>
                    <span class="nav-link-text ms-1">Master Mahasiswa</span>
                </a>
            </li>
            @endcan
            <hr class="horizontal dark mt-4 mb-2">
            <li class="nav-item mt-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent text-dark"
                        style="cursor:pointer; width:100%; text-align:left;">
                        <i class="material-symbols-rounded opacity-5">logout</i>
                        <span class="nav-link-text ms-1">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
