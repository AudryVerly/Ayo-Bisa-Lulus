@extends('layouts.app')
@section('breadcrumb', 'List Tugas Student Employee')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">List Tugas Student Employee</h6>
                            <a href="{{ route('tugas.showcreate', $idUnit) }}"
                                class="btn bg-white text-dark border shadow-sm">
                                <i class="material-symbols-rounded text-sm align-middle text-success">add</i>
                                <span class="align-middle fw-bold">Tambah Tugas</span>
                            </a>
                        </div>
                    </div>

                    <div class="card-body" px-2 pb-2>
                        <div class="table-responsive p-0">
                            <table id="tablelistugas" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Nama Mahasiswa</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Nama Tugas</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Bobot Nilai</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Tenggat Pengumpulan</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Submit</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Progress Tugas</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">File</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $d)
                                        <tr>
                                            <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $d->namaMahasiswa }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $d->namaTugas }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $d->bobotNilai }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $d->tenggatPengumpulan }}
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $d->tanggalPengumpulan ?? '-' }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    @if ($d->progressTugas == 'assigned')
                                                        <span class="badge bg-gradient-info text-white px-3 py-2">Di
                                                            Tugaskan</span>
                                                    @elseif ($d->progressTugas == 'inProgress')
                                                        <span
                                                            class="badge bg-gradient-warning text-white px-3 py-2">Proses</span>
                                                    @elseif ($d->progressTugas == 'revisi')
                                                        <span
                                                            class="badge bg-gradient-primary text-white px-3 py-2">Revisi</span>
                                                    @else
                                                        <span
                                                            class="badge bg-gradient-success text-white px-3 py-2">Selesai</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    @if ($d->statusPengumpulan == 'tepatwaktu')
                                                        <span class="badge bg-gradient-success text-white px-3 py-2">Tempat
                                                            Waktu</span>
                                                    @elseif ($d->statusPengumpulan == 'terlambat')
                                                        <span
                                                            class="badge bg-gradient-danger text-white px-3 py-2">Terlambat</span>
                                                    @else
                                                        <span
                                                            class="badge bg-gradient-secondary text-white px-3 py-2">Belum</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-sm" style="text-align: center;">
                                                @if ($d->file_path)
                                                    <a href="{{ asset('storage/' . $d->file_path) }}" target="_blank"
                                                        class="btn btn-sm bg-gradient-primary">
                                                        Lihat
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    @if ($d->statusPengumpulan == 'submit' || $d->statusPengumpulan == 'telat')
                                                        <a href="" class="btn bg-gradient-success btn-sm text-white">
                                                            Nilai
                                                        </a>
                                                        <a href=""class="btn bg-gradient-danger btn-sm text-white">
                                                            Revisi
                                                        </a>
                                                    @else
                                                        <span class="badge bg-gradient-info text-white px-3 py-2">Belum
                                                            Dikerjakan</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tablelistugas').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    emptyTable: "Belum ada Tugas yang ditugaskan",
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
            })
        });
    </script>
@endpush
