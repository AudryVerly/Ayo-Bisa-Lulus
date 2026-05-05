@extends('layouts.app')
@section('breadcrumb', 'List Student Employee')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            @forelse ($mahasiswa as $m)
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card shadow-lg border-0 h-100 d-flex flex-column">
                        <div class="card-header bg-gradient-dark text-white">
                            <h6 class="mb-0 fw-bold text-white">
                                {{ $m->namaMahasiswa }}
                            </h6>
                        </div>

                        <div class="card-body flex-grow-1 py-3 px-3">
                            <div class="mb-2">
                                <div class="fw-semibold text-dark">
                                    Lowongan : {{ $m->judulLowongan ?? '-' }}
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="fw-semibold text-dark">
                                    Unit : {{ $m->namaUnit ?? '-' }}
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="fw-semibold text-dark"> Status :

                                    @if ($m->statusPendaftaran == 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak diketahui</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 pt-2 pb-3 px-3">
                            <a href="{{ route('tugasadmin.listtugasadmin', [$m->idMahasiswa, $m->idLowongan]) }}"
                                class="btn btn-outline-primary w-100">
                                Lihat Detail Tugas
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h6 class="text-muted">Belum ada mahasiswa yang diterima</h6>
                </div>
            @endforelse
        </div>
    </div>
@endsection
