@extends('layouts.app')
@section('breadcrumb', 'Master Unit')
@section('content')
    <div class="container-fluid py-2">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                <div
                    class ="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                    <h6 class="text-white text-capitalize m-0">Master Unit</h6>
                    <a href="{{ route('units.create') }}" class="btn bg-white text-dark border shadow-sm">
                        <i class="material-symbols-rounded text-sm align-middle text-success">add</i>
                        <span class="align-middle fw-bold">Tambah Unit</span>
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
            <div class="card-body px-0 pb-2 ">
                <div class="table-responsive px-3">
                    <table class="table table-hover align-middle mb-0 text-center table-sm">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">No</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Nama
                                </th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">
                                    Deskripsi</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Lokasi
                                </th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Kontak
                                </th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">
                                    emailUnit</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Status
                                </th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unit as $index => $units)
                                <tr class={{ $units->status == 0 ? 'table-secondary' : '' }}>
                                    <td class="text-sm">{{ $index + 1 }}</td>
                                    <td class="text-sm">{{ $units->name }}</td>
                                    <td class="text-wrap text-sm"
                                        style="max-width: 500px; white-space: normal; line-height: 1.2; padding: 6px 12px;">
                                        {{ $units->deskripsi }}</td>
                                    <td class="text-wrap text-sm"
                                        style="max-width: 220px; white-space: normal; line-height: 1.2; padding: 6px 12px;">
                                        {{ $units->lokasi }}</td>
                                    <td class="text-sm" style="padding: 10px 16px;">{{ $units->kontak }}</td>
                                    <td class="text-sm" style="padding: 10px 16px;">{{ $units->emailUnit }}</td>
                                    <td>
                                        @if ($units->status == 1)
                                            <span class="badge bg-gradient-success text-white px-3 py-2">Aktif</span>
                                        @else
                                            <span class="badge bg-gradient-danger text-white px-3 py-2">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('units.show', $units->id) }}"
                                                class="btn bg-gradient-info btn-sm text-white btn-view {{ $units->status == 0 ? 'd-none' : '' }}"
                                                data-id="{{ $units->id }}">View</a>

                                            <a href="{{ route('units.edit', $units->id) }}"
                                                class="btn bg-gradient-warning btn-sm text-white btn-edit {{ $units->status == 0 ? 'd-none' : '' }}"
                                                data-id = "{{ $units->id }}">Edit</a>

                                            @if ($units->status == 1)
                                                <button class="btn btn-danger btn-sm btn-toggle"
                                                    data-id={{ $units->id }} data-active="0">
                                                    <i
                                                        class= "material-symbols-rounded text-sm align-middle flex-grow-2">block</i>&nbsp;&nbsp;NonAktifkan
                                                </button>
                                            @else
                                                <button class="btn btn-success btn-sm btn-toggle"
                                                    data-id={{ $units->id }} data-active="1">
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
                    <nav aria-label="Paging page" class="mt-4">
                        <ul class="pagination justify-content-end">
                            <li class="page-item {{ $unit->onFirstPage() ? 'disabled' : '' }}">
                                <a class =" page-link {{ $unit->onFirstPage() ? 'bg-light text-secondary' : 'bg-dark text-white' }}"
                                    href="{{ $unit->previousPageUrl() ?? '#' }}">
                                    <span class="material-symbols-rounded">
                                        keyboard_arrow_left
                                    </span>
                                </a>
                            </li>

                            @for ($i = 1; $i <= $unit->lastPage(); $i++)
                                <li class="page-item {{ $unit->currentPage() == $i ? 'active' : '' }}">
                                    <a class ="page-link {{ $unit->currentPage() == $i ? 'bg-gradient-dark text-white border-0' : 'text-dark' }}"
                                        href="{{ $unit->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            <li class="page-item {{ !$unit->hasMorePages() ? 'disabled' : '' }} ">
                                <a class =" page-link {{ !$unit->hasMorePages() ? 'bg-light text-secondary' : 'bg-dark text-white' }}"
                                    href="{{ $unit->nextPageUrl() ?? '#' }}">
                                    <span class="material-symbols-rounded">keyboard_arrow_right</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('alert-message');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);

        $(document).ready(function(response) {
            $('.btn-toggle').click(function() {
                const id = $(this).data('id');
                const activate = $(this).data('active') == 1;
                const row = $(this).closest('tr');
                const viewBtn = row.find('.btn-view');
                const editBtn = row.find('.btn-edit');
                const badge = row.find('td:nth-child(7) span');
                const button = $(this);
                const url = activate ? `/units/${id}/active` : `/units/${id}/destroy`;
                const actionText = activate ? 'mengaktifkan' : 'menonaktifkan';

                Swal.fire({
                    title: `Apakah kamu yakin ingin ${actionText} unit ini?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (activate) {
                                    // Ubah jadi aktif
                                    row.removeClass('table-secondary');
                                    viewBtn.removeClass('d-none');
                                    editBtn.removeClass('d-none');
                                    badge.removeClass('bg-gradient-danger')
                                        .addClass('bg-gradient-success')
                                        .text('Aktif');
                                    button.removeClass('btn-success')
                                        .addClass('btn-danger')
                                        .html(
                                            '<i class="material-symbols-rounded text-sm align-middle">block</i>&nbsp;Nonaktifkan'
                                        );
                                    button.data('active', 0);
                                } else {
                                    // Ubah jadi nonaktif
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
                                    text: 'Terjadi kesalahan saat mengubah status unit.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
