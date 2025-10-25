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
                <div id="alert-message" class="alert alert-success alert-dismissible text-white" role="alert">
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
                                    <td class="text-wrap text-sm" style="max-width: 500px; white-space: normal; line-height: 1.2; padding: 6px 12px;">
                                        {{ $units->deskripsi }}</td>
                                    <td class="text-wrap text-sm" style="max-width: 220px; white-space: normal; line-height: 1.2; padding: 6px 12px;">
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
                                            <a href=""
                                                class="btn bg-gradient-info btn-sm text-white btn-view {{ $units->status == 0 ? 'd-none' : '' }}"
                                                data-id="{{ $units->id }}">View</a>

                                            <a href=""
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
                </div>
            </div>
        </div>
    </div>
@endsection
