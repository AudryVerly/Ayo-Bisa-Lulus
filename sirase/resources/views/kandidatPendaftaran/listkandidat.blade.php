@extends('layouts.app')
@section('breadcrumb', 'List Kandidat')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">List Lowongan</h6>
                        </div>
                    </div>
                    <div class="card-body px-2 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tableListKandidat" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Kandidat</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">NRP</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Tanggal Daftar</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status Pendaftaran</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Tahapan</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kandidat as $index => $kan)
                                        <tr>
                                            <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $kan->namaKandidat }} <br>
                                                <small class="text-muted">{{ $kan->kandidatEmail }}</small>
                                            </td>
                                            <td class="text-sm" style="text-align: center;">{{ $kan->nrp }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $kan->tanggalDaftar }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center ">
                                                    @if ($kan->statusPendaftaran == 'terdaftar')
                                                        <span
                                                            class="badge bg-gradient-secondary text-white px-3 py-2">Terdaftar</span>
                                                    @elseif ($kan->statusPendaftaran == 'diproses')
                                                        <span class="badge bg-gradient-warning text-white px-3 py-2">Sedang
                                                            Diproses</span>
                                                    @elseif ($kan->statusPendaftaran == 'diterima')
                                                        <span
                                                            class="badge bg-gradient-success text-white px-3 py-2">DiTerima</span>
                                                    @elseif ($kan > statusPendaftaran == 'ditolak')
                                                        <span
                                                            class="badge bg-gradient-danger text-white px-3 py-2">DiTolak</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-sm" style="text-align: center;">{{ $kan->tahapIni }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('kandidat.detailKandidat', $kan->idPendaftaran) }} "
                                                        class="btn bg-gradient-info btn-sm text-white">
                                                        Detail Kandidat
                                                    </a>
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
            $('#tableListKandidat').DataTable({
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
            })
        });
    </script>
@endpush
