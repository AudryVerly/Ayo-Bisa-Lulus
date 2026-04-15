@extends('layouts.app')
@section('breadcrumb', 'List Unit')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h4 class="fw-bold mb-1">List Unit</h4>
            <small class="text-muted">Pilih unit untuk melihat dan mengelola tugas</small>
        </div>
        <div class="row g-4">
            @forelse ($unit as $u)
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100 rounded-3">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <h5 class="fw-bold mb-1">
                                    {{ $u->name }}
                                </h5>

                                <small class="text-muted">
                                    Unit Kerja
                                </small>
                            </div>
                            <p class="text-muted small mb-1">
                                Kelola tugas, monitoring progress, dan assign pekerjaan untuk student employee dalam unit
                                ini.
                            </p>
                            <a href="{{ route('tugas.listtugas',$u->id) }}" class="btn btn-dark w-100 mt-3">
                                Lihat Tugas →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center mb-0">
                        Tidak ada unit yang tersedia
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
