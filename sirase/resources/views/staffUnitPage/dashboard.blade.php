@extends('layouts.app')
@section('breadcrumb', 'Dashboard')
{{-- @section('title', 'Dashboard') --}}

@section('content')
    <div class="container-fluid py-3">
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h5 class="mb-1">Dashboard Staff Unit</h5>
                <span class="text-muted">
                    Unit: {{ $unit->implode(', ') ?: '-' }}
                </span>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6>Total Kandidat</h6>
                        <h3 class="mb-0">{{ $totalKandidat }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6>Belum dinilai</h6>
                        <h3 class="mb-0 text-danger">{{ $belumDinilai }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6>Sudah Dinilai</h6>
                        <h3 class="mb-0 text-success">{{ $sudahDinilai }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @if ($jadwal)
            <div class="card border-0 shadow-sm mb-4"
                style="border-left: 5px solid #5e72e4 !important; border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary-soft text-primary uppercase shadow-none font-weight-bold"
                                    style="font-size: 0.7rem; letter-spacing: 1px;">
                                    JADWAL WAWANCARA TERDEKAT
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">
                                {{ $jadwal->namaMahasiswa }}
                            </h4>
                        </div>

                        <div class="col-md-4 mt-3 mt-md-0 border-start-md">
                            <div class="ps-md-4">
                                <div class="d-flex align-items-center mb-2 text-dark">
                                    <div class="icon-shape icon-xs bg-dark rounded-circle me-2 d-flex align-items-center justify-content-center"
                                        style="width: 30px; height: 30px;">
                                        <i class="material-symbols-rounded" style="font-size: 0.8rem;">calendar_month</i>
                                    </div>
                                    <span class="small fw-600">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center text-dark">
                                    <div class="icon-shape icon-xs bg-dark rounded-circle me-2 d-flex align-items-center justify-content-center"
                                        style="width: 30px; height: 30px;">
                                        <i class="material-symbols-rounded"
                                            style="font-size: 0.8rem;">nest_clock_farsight_analog</i>
                                    </div>
                                    <span class="small fw-600">
                                        {{ $jadwal->mulai }} - {{ $jadwal->selesai }} WIB
                                    </span>
                                </div>
                                {{-- <div class="d-flex align-items-center mt-2 text-dark">
                                    <strong>Penilai:</strong> {{ $jadwal->penilaiStr ?? '-' }}
                                </div> --}}
                                @if ($jadwal->link && trim($jadwal->link) !== '')
                                    <a href="{{ $jadwal->link_wawancara }}" target="_blank"
                                        class="btn btn-primary mt-2">Join
                                        Wawancara</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-white">Belum ada jadwal wawancara terdekat yang Anda nilai.</div>
        @endif
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="card-header bg-white">
                <h6 class="mb-0">Riawayat Kandidat</h6>
            </div>

            <div class="card-body p-0">
                <table id ="tablekandidat" class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Nama</th>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Tanggal</th>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Mulai</th>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kandidat as $k)
                            <tr>
                                <td class="text-sm" style="text-align: center;">{{ $k->nama }}</td>
                                <td class="text-sm" style="text-align: center;">
                                    {{ \Carbon\Carbon::parse($k->tanggal)->translatedFormat('d F Y') }}</td>
                                <td class="text-sm" style="text-align: center;">{{ $k->mulai }}</td>
                                <td class="text-sm" style="text-align: center;">
                                    @if ($k->status == 'sudah')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-warning">Terjadwal</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $('#tablekandidat').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                // emptyTable: "Semua lowongan sudah lengkap",
                paginate: {
                    previous: "<",
                    next: ">",
                }
            },
            lengthMenu: [5, 10, 25, 50, 100],
            columnDefs: [
                //ini supaya tabel index terakhir gak bisa disort
                {
                    orderable: false,
                    targets: -1
                }
            ]
        });
    </script>
@endpush
