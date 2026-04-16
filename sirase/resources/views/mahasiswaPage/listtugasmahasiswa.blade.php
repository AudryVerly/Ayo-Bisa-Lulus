@extends('layouts.app')
@section('breadcrumb', 'List Tugas')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">List Tugas Student Employee</h6>
                        </div>
                    </div>
                    <div class="card-body px-2 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tableListTugas" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Tugas</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Tenggat Pegumpulan</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Tanggal Pengumpulan</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Detail</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tugas as $index => $t)
                                        <tr>
                                            <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $t->namaTugas }}</td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ \Carbon\Carbon::parse($t->tenggatPengumpulan)->translatedFormat('d F Y ') }}
                                            </td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $t->tanggalPengumpulan ? \Carbon\Carbon::parse($t->tanggalPengumpulan)->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $t->statusPengumpulan ?? '-' }}</td>
                                            <td class="text-sm" style="text-align: center;">
                                                <button type="button" class="btn btn-sm bg-gradient-info text-white"
                                                    data-bs-toggle="modal" data-bs-target="#detailModal{{ $t->id }}">
                                                    Detail Tugas
                                                </button>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    @if ($t->progressTugas == 'assigned')
                                                        <a href="" class="btn btn-sm bg-gradient-warning text-white">
                                                            Proses
                                                        </a>
                                                    @endif

                                                    @if ($t->progressTugas == 'proses')
                                                        <a href="" class="btn btn-sm bg-gradient-success text-white">
                                                            Submit
                                                        </a>
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
        </div>
    </div>
@endsection
@push('modals')
    @foreach ($tugas as $t)
        <div class="modal fade" id="detailModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Detail Tugas </h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-3 border rounded mb-3">
                            <small class="text-muted">Staff Pemberi Tugas</small>
                            <div class="fw-bold">{{ $t->namaUser }}</div>
                        </div>

                        <div class="p-3 border rounded mb-3">
                            <small class="text-muted">Nama Tugas</small>
                            <div class="fw-bold">{{ $t->namaTugas }}</div>
                        </div>

                        <div class="p-3 border rounded mb-3">
                            <small class="text-muted">Deskripsi</small>
                            <div>{{ $t->deskripsi }}</div>
                        </div>

                        <div class="p-3 border rounded">
                            <small class="text-muted">Deadline</small>
                            <div class="fw-bold text-danger">
                                {{ \Carbon\Carbon::parse($t->tenggatPengumpulan)->translatedFormat('d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endpush
