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
                            <h6 class="text-white text-capitalize m-0">Master User</h6>
                            <a href="" class="btn bg-white text-dark border shadow-sm">
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
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
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
                                                {{ $lowongans->judulLowongan }}</td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $lowongans->posisiLowongan }}
                                            </td>
                                            <td class="text-sm" style="text-align: center;">{{ $lowongans->unit->name }}
                                            </td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $lowongans->durasiKerja }}</td>
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
