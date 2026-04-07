@extends('layouts.app')
@section('breadcrumb', 'Dashboard')
{{-- @section('title', 'Dashboard') --}}

@section('content')
    <div class="container-fluid py-4">
        {{-- untuk data data diatas --}}
        <div class="row mb-2">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="text-dark mb-2">Total Lowongan</p>
                        <h4 class="fw-bold">{{ $totalLowongan }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="text-dark mb-2">Lowongan Aktif</p>
                        <h4 class="fw-bold">{{ $lowonganAktif }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="text-dark mb-2">Lowongan Sudah Tutup</p>
                        <h4 class="fw-bold">{{ $lowonganTutup }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="text-dark mb-2">Belum Lengkap</p>
                        <h4 class="fw-bold text-danger">{{ $lowonganBelumLengkap->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Kalender Pelaksanaan Lowongan</h5>
                <div id="calendar"></div>
            </div>
        </div>

        {{-- lowongan belum lengkap --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Lowongan Belum Lengkap</h5>
                <table id="lowonganbelumtable" class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Nama Lowongan</th>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lowonganBelumLengkap as $l)
                            <tr>
                                <td class="text-sm" style="text-align: center;">{{ $l->namaLowongan }}</td>
                                <td class="text-sm" style="text-align: center;">
                                    @if ($l->kurang_tahapan && $l->kurang_formulir)
                                        <span class="badge bg-danger">Tahapan & Formulir Belum Ada</span>
                                    @elseif($l->kurang_tahapan)
                                        <span class="badge bg-warning text-dark">Tahapan Belum Ada</span>
                                    @elseif($l->kurang_formulir)
                                        <span class="badge bg-info text-dark">Formulir Belum Ada</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ini untuk status kandidat --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">Kandidat Perlu ditindak</h5>
                <table id="kandidattindakantable" class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Nama Kandidat</th>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Nama Lowongan</th>
                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kandidatPerluTindakan as $k)
                            <tr>
                                <td class="text-sm" style="text-align: center;">{{ $k->namaKandidat }}</td>
                                <td class="text-sm" style="text-align: center;">{{ $k->namaLowongan }}</td>
                                <td class="text-sm" style="text-align: center;">
                                    @if ($k->belumadajadwal)
                                        <span class="badge bg-danger">Belum ada jadwal Wawancara</span>
                                    @elseif($k->jumlahPenilai == 0)
                                        <span class="badge bg-warning text-dark">
                                            Belum Ada Penilai
                                        </span>
                                    @elseif($k->sudahMenilai < $k->jumlahPenilai)
                                        <span class="badge bg-warning text-dark">
                                            Penilaian Belum Lengkap
                                            ({{ $k->sudahMenilai }}/{{ $k->jumlahPenilai }})
                                        </span>
                                    @elseif($k->belumdinilai)
                                        <span class="badge bg-danger">Belum dinilai</span>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                height: '75vh',

                events: @json($events),

                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },

                displayEventTime: true,
                displayEventEnd: true,

                eventClick: function(info) {
                    let data = info.event.extendedProps || {};
                    let html = '';

                    if (data.tipe === 'wawancara') {
                        html: `
                            <b>Kandidat:</b> ${data.kandidat ?? '-'} <br>
                            <b>Lowongan:</b> ${data.lowongan ?? '-'} <br>
                            <b>Tipe:</b> ${data.tipe ?? '-'}
                        `;
                    }

                    Swal.fire({
                        title: info.event.title,
                        html: html,
                        icon: "info",
                        confirmButtonText: "Tutup"
                    });
                }
            });

            calendar.render();

            $('#lowonganbelumtable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    emptyTable: "Semua lowongan sudah lengkap",
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

            $('#kandidattindakantable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    emptyTable: "Semua Kandidat Sudah Aman",
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
        });
    </script>
@endpush
