@extends('layouts.app')
@section('breadcrumb', 'Master Kriteria')

@section('content')
    <div class="container-fluid py-2">
        <div class="card my-4">
            <div
                class ="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                <h6 class="text-white text-capitalize m-0">Master Kriteria</h6>
                <button class="btn bg-white text-dark border shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#modaladdKriteria">
                    <i class="material-symbols-rounded text-sm align-middle text-success">add</i>
                    <span class="align-middle fw-bold">Tambah Kriteria</span>
                </button>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive px-3">
                    <table id="kriteriatable" class="table table-hover align-middle mb-0 text-center table-sm">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">No</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Nama Kriteria</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Status</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteria as $index => $kriterias)
                                <tr class={{ $kriterias->status == 0 ? 'table-secondary' : '' }}>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">{{ $index + 1 }}
                                    </td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $kriterias->namaKriteria ?? '-' }}</td>
                                    <td style="padding: 10px 16px; text-align: center;">
                                        @if ($kriterias->status == 1)
                                            <span class="badge bg-gradient-success text-white px-3 py-2">Aktif</span>
                                        @else
                                            <span class="badge bg-gradient-danger text-white px-3 py-2">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    <div class="modal fade" id="modaladdKriteria" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('kriteria.store') }}" method="POST">
                    @csrf
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Tambah Kriteria</h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-1">
                            <label for="name" class="form-label fw-bold text-secondary">Nama Kriteria</label>
                            <div class="custom-tooltip"
                                data-title="Masukkan nama kriteria anda,wajib diisi apabila ingin menginput">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <input type="text" class="form-control border rounded-3 px-3 py-2" name="namaKriteria"
                                id="namaUrutan" value="{{ old('namaKriteria') }}">
                            @error('namaKriteria')
                                <div class="text-danger" id="errorName">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#kriteriatable').DataTable({
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
        })
    </script>
@endpush
