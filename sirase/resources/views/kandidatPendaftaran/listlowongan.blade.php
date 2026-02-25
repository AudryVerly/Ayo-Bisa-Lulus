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
                            <h6 class="text-white text-capitalize m-0">List Lowongan</h6>
                        </div>
                    </div>
                    <div class="card-body px-2 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tableListLowongan" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Nama Lowongan</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Jumlah Kandidat</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lowongan as $index => $low)
                                        <tr class={{ $low->status == 0 ? 'table-secondary' : '' }}>
                                            <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                                {{ $low->judulLowongan }}
                                            </td>
                                            <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                                {{ $low->pendaftaran_count }}
                                            </td>
                                            <td style="padding: 10px 16px; text-align: center;">
                                                @if ($low->status == 1)
                                                    <span
                                                        class="badge bg-gradient-success text-white px-3 py-2">Aktif</span>
                                                @else
                                                    <span
                                                        class="badge bg-gradient-danger text-white px-3 py-2">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="" class="btn bg-gradient-info btn-sm text-white">
                                                        Lihat Kandidat
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
            $('#tableListLowongan').DataTable({
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
