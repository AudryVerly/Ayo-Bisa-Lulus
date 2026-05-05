@extends('layouts.app')
@section('breadcrumb', 'List Lowongan')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">List Lowongan Student Employee</h6>
                        </div>
                    </div>
                    <div class="card-body px-2 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tableLowongan" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Lowongan</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Unit</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lowongan as $index => $low)
                                        <tr>
                                            <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                            <td class="text-sm" style="text-align: center;">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold">{{ $low->judulLowongan }}</span>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($low->mulaiKerja)->format('d M Y') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($low->akhirKerja)->format('d M Y') }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="text-sm" style="text-align: center;">{{$low->name}}</td>
                                            <td class="text-sm" style="text-align: center;">
                                                @if (now() < $low->mulaiKerja)
                                                    <span class="badge bg-gradient-secondary px-3 py-2">
                                                        Belum Mulai
                                                    </span>
                                                @elseif (now() > $low->akhirKerja)
                                                    <span class="badge bg-gradient-dark px-3 py-2">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="badge bg-gradient-success px-3 py-2">
                                                        Aktif
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="text-sm" style="text-align: center;">
                                                <a href="{{ route('tugasmahasiswa.listtugas',$low->id) }}" class="btn btn-sm bg-gradient-info text-white">
                                                    Lihat Tugas
                                                </a>
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
            $('#tableLowongan').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    emptyTable: 'Belum ada Lowongan',
                    paginate: {
                        previous: "<",
                        next: ">",
                    }
                },
                lengthMenu: [5, 10, 25, 50, 100],
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }]
            });
        });
    </script>
@endpush
