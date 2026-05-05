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
                                @php
                                    $dipakai = $kriterias->bobotKriteria->count() > 0;
                                @endphp
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
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm btnEdit" data-id={{ $kriterias->id }}
                                            data-nama="{{ $kriterias->namaKriteria }}"
                                            {{ $dipakai || $kriterias->status == 0 ? 'disabled' : '' }}>
                                            Edit
                                        </button>
                                        <form action="{{ route('kriteria.toggle', $kriterias->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button
                                                class="btn btn-{{ $kriterias->status == 1 ? 'danger' : 'success' }} btn-sm btnToggle"
                                                type="button" {{ $dipakai ? 'disabled' : '' }}>
                                                {{ $kriterias->status == 1 ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
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
                                id="namaKriteria" value="{{ old('namaKriteria') }}">
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

    <div class= "modal fade" id="modaleditKriteria" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditKriteria" method="POST">
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Edit Kriteria</h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-1">
                            <label for="name" class="form-label fw-bold text-secondary">Nama Kriteria</label>
                            <div class="custom-tooltip"
                                data-title="Masukkan nama kriteria anda,wajib diisi apabila ingin menginput">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <input type="text" class="form-control border rounded-3 px-3 py-2" name="namaKriteria"
                                id="editNamaKriteria" value="{{ old('namaKriteria') }}">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

            $('.btnToggle').click(function() {
                let form = $(this).closest('form');
                let actionText = $(this).text().trim();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan " + actionText.toLowerCase() + " kriteria ini.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, ' + actionText.toLowerCase() + '!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: "{{ session('error') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif

            @if ($errors->any())
                @if (old('namaKriteria') && request()->routeIs('kriteria.store'))
                    $('#modaladdKriteria').modal('show');
                @elseif (old('namaKriteria') && request()->routeIs('kriteria.update'))
                    $('#modaleditKriteria').modal('show');
                @endif
            @endif
        });

        $(document).on('click', '.btnEdit', function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');

            $('#editNamaKriteria').val(nama)

            $('#formEditKriteria').attr(
                'action',
                '/kriteria/' + id + '/update'
            );

            $('#modaleditKriteria').modal('show')

        });
    </script>
@endpush
