@extends('layouts.app')
@section('breadcrumb', 'Master Mahasiswa')

@section('content')
    <div class="container-fluid py-2">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                <div
                    class ="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                    <h6 class="text-white text-capitalize m-0">Master Mahasiswa</h6>
                    <a href="{{ route('mahasiswa.create') }}" class="btn bg-white text-dark border shadow-sm">
                        <i class="material-symbols-rounded text-sm align-middle text-success">add</i>
                        <span class="align-middle fw-bold">Tambah Mahasiswa</span>
                    </a>
                </div>
            </div>
            @if (session('success'))
                <div id="alert-message" class="alert alert-success alert-dismissible text-white" role="alert">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div id="alert-message" class="alert alert-danger alert-dismissible text-white" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card-body px-0 pb-2">
                <div class="table-responsive px-3">
                    <table id ="mahasiswatable" class="table table-hover align-middle mb-0 text-center table-sm">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">No</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Nama</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Email Mahasiswa</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">NRP</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Fakultas</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Jurusan</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Tahun Masuk</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">No Telepon</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Status</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswa as $index => $mahasiswas)
                                <tr class={{ $mahasiswas->status == 0 ? 'table-secondary' : '' }}>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">{{ $index + 1 }}
                                    </td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $mahasiswas->user->name ?? '-' }}</td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $mahasiswas->user->email ?? '-' }}</td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $mahasiswas->nrp ?? '-' }}</td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $mahasiswas->fakultas ?? '-' }}</td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $mahasiswas->jurusan ?? '-' }}</td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $mahasiswas->tahunMasuk ?? '-' }}</td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $mahasiswas->noTelepon ?? '-' }}</td>
                                    <td style="padding: 10px 16px; text-align: center;">
                                        @if ($mahasiswas->status == 1)
                                            <span class="badge bg-gradient-success text-white px-3 py-2">Aktif</span>
                                        @else
                                            <span class="badge bg-gradient-danger text-white px-3 py-2">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2" style="text-align: center;">
                                            <a href="{{ route('mahasiswa.show', $mahasiswas->id) }}"
                                                class="btn bg-gradient-info btn-sm text-white btn-view {{ $mahasiswas->status == 0 ? 'd-none' : '' }}"
                                                data-id="{{ $mahasiswas->id }}">View</a>

                                            <a href="{{ route('mahasiswa.edit', $mahasiswas->id) }}"
                                                class="btn bg-gradient-warning btn-sm text-white btn-edit {{ $mahasiswas->status == 0 ? 'd-none' : '' }}"
                                                data-id = "{{ $mahasiswas->id }}">Edit</a>

                                            @if ($mahasiswas->status == 1)
                                                <button class="btn btn-danger btn-sm btn-toggle"
                                                    data-id={{ $mahasiswas->id }} data-active="0">
                                                    <i
                                                        class= "material-symbols-rounded text-sm align-middle flex-grow-2">block</i>&nbsp;&nbsp;NonAktifkan
                                                </button>
                                            @else
                                                <button class="btn btn-success btn-sm btn-toggle"
                                                    data-id={{ $mahasiswas->id }} data-active="1">
                                                    <i
                                                        class= "material-symbols-rounded text-sm align-middle">check_circle</i>&nbsp;&nbsp;Aktifkan
                                                </button>
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
@endsection
@push('scripts')
    {{-- ini buat alert dialog --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    {{-- ini scriptnya datable --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#mahasiswatable').DataTable({
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
        //kalau ini supaya alertnya hilang dalam 2 detik 
        setTimeout(() => {
            const alert = document.getElementById('alert-message');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500); //hapus elemen setelah fade out
            }
        }, 3000); //muncul selama 3 detik

        $(document).ready(function(response) {
            //jadi ketika semua sudah siap dijalankan kita ambil data terlebih dahulu
            $('.btn-toggle').click(function() {
                //ini merupakan id dari data
                const id = $(this).data('id');
                const activate = $(this).data('active') == 1;
                const row = $(this).closest('tr');
                const viewBtn = row.find('.btn-view');
                const editBtn = row.find('.btn-edit');
                //ini merupakan bagian tulisan aktif non aktifkan
                const badge = row.find('td:nth-child(10) span');
                //button ini adalag button toggle atau this itu berisi semua js yang akan dilakukan 
                const button = $(this);
                //ini untuk mengambil dari url untuk mengupdate statusmya
                const url = activate ? `/mahasiswas/${id}/active` : `/mahasiswas/${id}/destroy`;
                const actionText = activate ? 'mengaktifkan' : 'mengnonaktifkan';

                Swal.fire({
                    title: `Apakah kamu yakin ingin ${actionText} mahasiswa ini?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //ini adalah ajax yang digunakan untuk request perubahan dari keamanan laravel
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                //ini kalau di aktifkan makan semua button akan ditampilkan
                                if (activate) {
                                    row.removeClass('table-secondary');
                                    viewBtn.removeClass('d-none');
                                    editBtn.removeClass('d-none');
                                    badge.removeClass('bg-gradient-danger')
                                        .addClass('bg-gradient-success')
                                        .text('Aktif');
                                    button.removeClass('btn-success')
                                        .addClass('btn-danger')
                                        .html(
                                            '<i class="material-symbols-rounded text-sm align-middle">block</i>&nbsp;NonAktifkan'
                                        );
                                    button.data('active', 0);
                                    //ini buat kalau mau matiin buttonya
                                } else {
                                    row.addClass('table-secondary');
                                    viewBtn.addClass('d-none');
                                    editBtn.addClass('d-none');
                                    badge.removeClass('bg-gradient-success')
                                        .addClass('bg-gradient-danger')
                                        .text('Nonaktif');
                                    button.removeClass('btn-danger')
                                        .addClass('btn-success')
                                        .html(
                                            '<i class="material-symbols-rounded text-sm align-middle">check_circle</i>&nbsp;Aktifkan'
                                        );
                                    button.data('active', 1);
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan saat mengubah status user.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
