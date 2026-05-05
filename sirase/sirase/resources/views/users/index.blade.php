@extends('layouts.app')
@section('breadcrumb', 'Master User')
{{-- @section('title', 'Master User') --}}

@section('content')
    <div class ="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class ="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">Master User</h6>
                            <a href="{{ route('users.create') }}" class="btn bg-white text-dark border shadow-sm">
                                <i class="material-symbols-rounded text-sm align-middle text-success">add</i>
                                <span class="align-middle fw-bold">Tambah User</span>
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div id ="alert-message" class="alert alert-success alert-dismissible text-white" role="alert">
                            {{ session('success') }}</div>
                    @elseif (session('error'))
                        <div id ="alert-message" class="alert alert-danger alert-dismissible text-white" role="alert">
                            {{ session('error') }}</div>
                    @endif
                    <div class="card-body px-2 pb-2">
                        <div class ="table-responsive p-0">
                            {{-- css ini ada dibagian tabel fit --}}
                            <table class ="table align-items-center mb-0" id="usertable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Nama
                                        </th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center">Email
                                        </th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Role
                                        </th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status
                                        </th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $index => $users)
                                        <tr class={{ $users->status == 0 ? 'table-secondary' : '' }}>
                                            <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $users->name }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $users->email }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $users->role }}</td>
                                            {{-- <td>{{ $users->status }}</td> --}}
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center ">
                                                    @if ($users->status == 1)
                                                        <span
                                                            class="badge bg-gradient-success text-white px-3 py-2">Aktif</span>
                                                    @else
                                                        <span
                                                            class="badge bg-gradient-danger text-white px-3 py-2">Nonaktif</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    {{-- data-id ini merupakan untuk mengambil id atau data dari baris yang sedang kita kerjakan --}}
                                                    <a href="{{ route('users.show', $users->id) }}"
                                                        class="btn bg-gradient-info btn-sm text-white btn-view {{ $users->status == 0 ? 'd-none' : '' }}"
                                                        data-id="{{ $users->id }} text-sm">View</a>

                                                    <a href="{{ route('users.edit', $users->id) }}"
                                                        class="btn bg-gradient-warning btn-sm text-white btn-edit {{ $users->status == 0 ? 'd-none' : '' }}"
                                                        data-id = "{{ $users->id }}">Edit</a>

                                                    @if ($users->status == 1)
                                                        <button class="btn btn-danger btn-sm btn-toggle"
                                                            data-id={{ $users->id }} data-active="0">
                                                            <i
                                                                class= "material-symbols-rounded btn-sm text-sm align-middle flex-grow-2">block</i>&nbsp;&nbsp;NonAktifkan
                                                        </button>
                                                    @else
                                                        <button class="btn btn-success btn-sm btn-toggle"
                                                            data-id={{ $users->id }} data-active="1">
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
                            {{-- <div class="d-flex justify-content-center mt-3">
                                {{ $user->links('pagination::bootstrap-5') }}
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    {{-- ini scriptnya datable --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    {{-- ini buat alert dialog --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $("#usertable").DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    paginate: {
                        previous: "<",
                        next: ">",
                    }
                },
                //ini untuk mengatur entris yang mau ditampilin
                lengthMenu:[5, 10 , 25 , 50 , 100],
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
                const badge = row.find('td:nth-child(5) span');
                //button ini adalag button toggle atau this itu berisi semua js yang akan dilakukan 
                const button = $(this);
                //ini untuk mengambil dari url untuk mengupdate statusmya
                const url = activate ? `/users/${id}/active` : `/users/${id}/destroy`;
                const actionText = activate ? 'mengaktifkan' : 'mengnonaktifkan';

                Swal.fire({
                    title: `Apakah kamu yakin ingin ${actionText} user ini?`,
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
                                        .addClass('bg-success')
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
                                        .addClass('bg-secondary')
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
