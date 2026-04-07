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
                    <a class="nav-link {{ request()->is('dashboardMahasiswa*') || request()->routeIs('pendaftaran.formulir') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('mahasiswa.dashboard') }}">
                        <i class="material-symbols-rounded opacity-5">dashboard</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
            @endcan
            @can('role:StaffUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboardStaff*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('staff.dashboard') }}">
                        <i class="material-symbols-rounded opacity-5">dashboard</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
            @endcan
            @can('role:AdminUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboardAdminUnit*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('adminunit.dashboard') }}">
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
            @can('role:AdminUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('lowongans*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('lowongans.index') }}">
                        <i class="material-symbols-rounded opacity-5">work</i>
                        <span class="nav-link-text ms-1">Lowongan</span>
                    </a>
                </li>
            @endcan
            @can('role:AdminUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('formulir*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('formulir.utama') }}">
                        <i class="material-symbols-rounded opacity-5">list_alt</i>
                        <span class="nav-link-text ms-1">Formulir</span>
                    </a>
                </li>
            @endcan
            @can('role:AdminUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('tahapan*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('tahapan.utama') }}">
                        <i class="material-symbols-rounded opacity-5">cards_stack</i>
                        <span class="nav-link-text ms-1">Tahapan Rekrutmen</span>
                    </a>
                </li>
            @endcan
            @can('role:AdminUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('penilaian*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('timPenilai.utama') }}">
                        <i class="material-symbols-rounded opacity-5">leaderboard</i>
                        <span class="nav-link-text ms-1">Tim Penilai</span>
                    </a>
                </li>
            @endcan
            @can('role:AdminUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kandidat*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('kandidat.listLowongan') }}">
                        <i class="material-symbols-rounded opacity-5">groups_2</i>
                        <span class="nav-link-text ms-1">Detail Kandidat</span>
                    </a>
                </li>
            @endcan
            @can('role:Mahasiswa')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('riwayatPendaftaran*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('riwayatPendaftaran.list') }}">
                        <i class="material-symbols-rounded opacity-5">assignment</i>
                        <span class="nav-link-text ms-1">Riwayat Pendaftaran</span>
                    </a>
                </li>
            @endcan
            @can('role:Mahasiswa')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('listwawancaramahasiswa*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('listwawancara.show') }}">
                        <i class="material-symbols-rounded opacity-5">calendar_month</i>
                        <span class="nav-link-text ms-1">List wawancara</span>
                    </a>
                </li>
            @endcan
            @can('role:StaffUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('listwawancarastaff*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('listwawancarastaff.show') }}">
                        <i class="material-symbols-rounded opacity-5">calendar_month</i>
                        <span class="nav-link-text ms-1">List wawancara</span>
                    </a>
                </li>
            @endcan
            @can('role:SuperAdmin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kriteria*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('kriteria.index') }}">
                        <i class="material-symbols-rounded opacity-5">variables</i>
                        <span class="nav-link-text ms-1">Kriteria</span>
                    </a>
                </li>
            @endcan
            @can('role:AdminUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kriteriaUnit*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('kriteria.showUnit') }}">
                        <i class="material-symbols-rounded opacity-5">variables</i>
                        <span class="nav-link-text ms-1">Kriteria</span>
                    </a>
                </li>
            @endcan
            @can('role:AdminUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('AHP*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('ahp.show') }}">
                        <i class="material-symbols-rounded opacity-5">calculate</i>
                        <span class="nav-link-text ms-1">Perhitungan Kriteria</span>
                    </a>
                </li>
            @endcan
            @can('role:AdminUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('nilaikandidat*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('kandidatadmin.listlowongan') }}">
                        <i class="material-symbols-rounded opacity-5">person_heart</i>
                        <span class="nav-link-text ms-1">Hasil Penilaian</span>
                    </a>
                </li>
            @endcan
            @can('role:StaffUnit')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('penilaiankandidat*') ? 'active bg-gradient-dark text-white' : 'text-dark' }}"
                        href="{{ route('penilaian.show') }}">
                        <i class="material-symbols-rounded opacity-5">credit_score</i>
                        <span class="nav-link-text ms-1">Kandidat Penilai</span>
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
