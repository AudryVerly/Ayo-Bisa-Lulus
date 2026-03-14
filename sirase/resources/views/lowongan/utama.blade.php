@extends('layouts.app')
@section('breadcrumb', 'Kelola Lowongan')

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">Lowongan</h6>
                            <a href="{{ route('lowongans.create') }}" class="btn bg-white text-dark border shadow-sm">
                                <i class="material-symbols-rounded text-sm align-middle text-success">add</i>
                                <span class="align-middle fw-bold">Tambah Lowongan</span>
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
                        <div class="table-responsive p-0">
                            <table id="lowongantable" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Poster</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Judul</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Posisi Lowongan</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Unit</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Durasi Kerja</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Awal Pendaftaran</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Akhir Pendafataran</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lowongan as $index => $lowongans)
                                        <tr class={{ $lowongans->status == 0 ? 'table-secondary' : '' }}>
                                            <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                            <td class="text-sm" style="text-align: center;">
                                                @if ($lowongans->poster)
                                                    <img src="{{ asset('storage/' . $lowongans->poster) }}" width="60"
                                                        class="rounded shadow-sm poster-click" style="cursor:pointer"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#posterModal{{ $lowongans->id }}">
                                                @else
                                                    <img src="{{ asset('template/img/noimage.jpg') }}" width="60"
                                                        class="rounded shadow-sm" style="opacity:.6">
                                                @endif

                                            </td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $lowongans->judulLowongan }}</td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $lowongans->posisiLowongan }}
                                            </td>
                                            <td class="text-sm" style="text-align: center;">{{ $lowongans->unit->name }}
                                            </td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $lowongans->durasiKerja }} bulan </td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $lowongans->awalPendaftaran }}</td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $lowongans->batasPendaftaran }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center ">
                                                    @if ($lowongans->status == 1)
                                                        <span
                                                            class="badge bg-gradient-success text-white px-3 py-2">Open</span>
                                                    @else
                                                        <span
                                                            class="badge bg-gradient-danger text-white px-3 py-2">Closed</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2"
                                                    style="text-align: center;">
                                                    {{-- ini tuh buat modal-> modal adalah kek popup di boostrap --}}
                                                    <button type="button" class="btn bg-gradient-info btn-sm text-white"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $lowongans->id }}">
                                                        Manage Form
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @push('modals')
                                            <div class="modal fade" id="detailModal{{ $lowongans->id }}" tabindex="-1"
                                                aria-labelledby="detailModalLabel{{ $lowongans->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div
                                                            class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                                                            <div>
                                                                <h5 class="modal-title"
                                                                    id="detailModalLabel{{ $lowongans->id }}"
                                                                    style="color: white;">
                                                                    {{ $lowongans->judulLowongan }}
                                                                </h5>
                                                                <small class="text-white-50">Detail Informasi Lowongan</small>
                                                            </div>

                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="d-flex flex-column align-items-end gap-1 me-1">
                                                                    <small class="text-white-50">Status Lowongan</small>

                                                                    @if ($lowongans->status == 1)
                                                                        <span class="badge bg-success px-3 py-2">Open</span>
                                                                    @else
                                                                        <span class="badge bg-danger px-3 py-2">Closed</span>
                                                                    @endif
                                                                </div>

                                                                <button type="button" class="btn-close btn-white"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>

                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="mb-2">
                                                                <strong>Posisi: </strong> {{ $lowongans->posisiLowongan }}
                                                            </div>
                                                            <div class="mb-2">
                                                                <strong>Unit: </strong> {{ $lowongans->unit->name ?? '-' }}
                                                            </div>
                                                            <div class="mb-2">
                                                                <strong>Durasi Kerja: </strong>
                                                                {{ $lowongans->durasiKerja ?? '-' }} bulan
                                                            </div>
                                                            <div class="mb-2">
                                                                <strong>Periode Pendaftaran: </strong>
                                                                {{ \Carbon\Carbon::parse($lowongans->awalPendaftaran)->translatedFormat('d F Y ') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($lowongans->batasPendaftaran)->translatedFormat('d F Y ') }}
                                                            </div>
                                                            <hr
                                                                style="border-top: 2px solid rgba(21, 21, 21, 0.2); margin: 1rem 0;">
                                                            <div class="mb-2">
                                                                <strong class="mb-1">Periode Kerja : </strong>
                                                                {{ \Carbon\Carbon::parse($lowongans->mulaiKerja)->translatedFormat('d F Y ') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($lowongans->akhirKerja)->translatedFormat('d F Y ') }}
                                                            </div>
                                                            <div class="mb-3">
                                                                <h6 class="mb-1">Deskripsi</h6>
                                                                <p>
                                                                    {{ $lowongans->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <h6 class="mb-1">Kualifikasi</h6>
                                                                @if (!empty($lowongans->kualifikasi))
                                                                    <ul>
                                                                        @foreach (explode("\n", $lowongans->kualifikasi) as $kuali)
                                                                            <li>{{ $kuali }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @else
                                                                    <p class="text-muted">Tidak ada kualifikasi tercatat.</p>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <div class="d-flex gap-2">
                                                                @if ($lowongans->status == 0)
                                                                    <form
                                                                        action="{{ route('lowongan.publish', $lowongans->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <button class="btn bg-gradient-primary btn-publish"
                                                                            data-id={{ $lowongans->id }}
                                                                            data-awal={{ $lowongans->awalPendaftaran }}
                                                                            data-akhir={{ $lowongans->batasPendaftaran }}
                                                                            data-status={{ $lowongans->status }}>
                                                                            <i
                                                                                class="material-symbols-rounded text-sm">publish</i><span
                                                                                class="align-middle">&nbsp;&nbsp;Publish
                                                                                Lowongan</span>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <form
                                                                        action="{{ route('lowongan.unpublish', $lowongans->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <button id="btn-unpublish"
                                                                            class="btn bg-gradient-warning btn-unpublish"
                                                                            data-id={{ $lowongans->id }}
                                                                            data-awal={{ $lowongans->awalPendaftaran }}
                                                                            data-akhir={{ $lowongans->batasPendaftaran }}
                                                                            data-status={{ $lowongans->status }}>
                                                                            <i
                                                                                class="material-symbols-rounded text-sm">unpublished</i><span
                                                                                class="align-middle">&nbsp;&nbsp;Unpublish
                                                                                Lowongan</span>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                                <a href="{{ route('lowongans.edit', $lowongans->id) }}"
                                                                    class="btn bg-gradient-info text-white px-4">
                                                                    <i class="material-symbols-rounded text-sm">edit</i><span
                                                                        class="align-middle">&nbsp;&nbsp;Edit Lowongan</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endpush

                                        @push('modals')
                                            <div class="modal fade" id="posterModal{{ $lowongans->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-0">
                                                            <h6 class="text-white">Poster Lowongan</h6>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <div class="modal-body text-center">

                                                            <img src="{{ asset('storage/' . $lowongans->poster) }}"
                                                                class="img-fluid rounded shadow">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endpush
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
        setTimeout(() => {
            const alert = document.getElementById('alert-message');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500); //hapus elemen setelah fade out
            }
        }, 3000);
        $(document).ready(function() {
            $('.btn-publish, .btn-unpublish').each(function() {
                let today = new Date();
                let awal = new Date($(this).data('awal'));
                let akhir = new Date($(this).data('akhir'));
                let status = $(this).data('status');
                let button = $(this)

                button.hide();

                if (today < awal) {
                    return;
                }

                if (today >= awal && today <= akhir) {
                    if (status == 0 && button.hasClass("btn-publish")) {
                        button.show();
                    }

                    if (status == 1 && button.hasClass("btn-unpublish")) {
                        button.show();
                    }

                    return;
                }

            });
        });
        $(document).ready(function() {
            $('#lowongantable').DataTable({
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
