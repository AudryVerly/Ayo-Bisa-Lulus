@extends('layouts.app')
@section('breadcrumb', 'Mahasiswa Detail')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card border-0 rounded-3 shadow-sm">
                    @csrf
                    <div class="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white d-flex align-items-center">
                            <i class="material-symbols-rounded text-sm text-white">school</i>&nbsp;Detail Mahasiswa
                        </h5>
                        <div class="d-flex align-items-center">
                            {{-- <a href="{{ route('mahasiswa.index') }}"
                                class="btn btn-light btn-sm d-flex align-items-center me-2">
                                <i class="material-symbols-rounded text-sm">arrow_back</i>&nbsp;Kembali
                            </a> --}}
                            <a href="" class="btn btn-warning btn-sm d-flex align-items-center">
                                <i class="material-symbols-rounded text-sm">edit</i>&nbsp;Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-5 py-4">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-secondary">Nama Mahasiswa</div>
                            <div class="col-md-8">{{ $mahasiswa->user->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-secondary">Email Mahasiswa</div>
                            <div class="col-md-8">{{ $mahasiswa->user->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-secondary">NRP Mahasiswa</div>
                            <div class="col-md-8">{{ $mahasiswa->nrp }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-secondary">Fakultas</div>
                            <div class="col-md-8">{{ $mahasiswa->fakultas }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-secondary">Jurusan</div>
                            <div class="col-md-8">{{ $mahasiswa->jurusan }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-secondary">Tahun Masuk</div>
                            <div class="col-md-8">{{ $mahasiswa->tahunMasuk }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-secondary">No. Telepon</div>
                            <div class="col-md-8">{{ $mahasiswa->noTelepon }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold text-secondary">Status</div>
                            <div class="col-md-8">
                                @if ($mahasiswa->status == 1)
                                    <span class="badge bg-success text-white px-3 py-2">AKTIF</span>
                                @else
                                    <span class="badge bg-danger text-white px-3 py-2">NON-AKTIF</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection