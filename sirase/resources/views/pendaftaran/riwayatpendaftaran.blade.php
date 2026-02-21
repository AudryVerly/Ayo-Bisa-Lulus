@extends('layouts.app')
@section('breadcrumb', 'Riyawat Pendaftaran')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">Riwayat Pendaftaran</h6>
                        </div>

                        <div class="card-body px-2 pb-2">
                            <div class="table-responsive p-0">
                                <table id="tableRiwayat" class="table align-items-center mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">No</th>
                                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">Lowongan</th>
                                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">Unit Tujuan</th>
                                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">Periode</th>
                                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">Tanggal Daftar</th>
                                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">Status</th>
                                            <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($riwayatPendaftaran as $index => $riwayat)
                                            <tr>
                                                <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                                <td class="text-sm" style="text-align: center;">{{ $riwayat->judul }}</td>
                                                <td class="text-sm" style="text-align: center;">{{ $riwayat->unitname }}
                                                </td>
                                                <td class="text-sm" style="text-align: center;">
                                                    {{ \Carbon\Carbon::parse($riwayat->mulai)->translatedFormat('d M Y') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($riwayat->mulai)->translatedFormat('d M Y') }}
                                                </td>
                                                <td class="text-sm" style="text-align: center;">
                                                    {{ \Carbon\Carbon::parse($riwayat->tanggal_daftar)->translatedFormat('d M Y') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center ">
                                                        @if ($riwayat->statusPendaftaran == 'terdaftar')
                                                            <span
                                                                class="badge bg-gradient-secondary text-white px-3 py-2">Terdaftar</span>
                                                        @elseif ($riwayat->statusPendaftaran == 'diproses')
                                                            <span
                                                                class="badge bg-gradient-warning text-white px-3 py-2">Sedang
                                                                Diproses</span>
                                                        @elseif ($riwayat->statusPendaftaran == 'diterima')
                                                            <span
                                                                class="badge bg-gradient-success text-white px-3 py-2">DiTerima</span>
                                                        @elseif ($riwayat->statusPendaftaran == 'ditolak')
                                                            <span
                                                                class="badge bg-gradient-danger text-white px-3 py-2">DiTolak</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2"
                                                        style="text-align: center;">
                                                        {{-- ini tuh buat modal-> modal adalah kek popup di boostrap --}}
                                                        <button type="button" class="btn btn-outline-info text-sm"
                                                            style="text-align: center;">
                                                            Detail
                                                        </button>
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
    </div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tableRiwayat').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
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
