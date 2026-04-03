@extends('layouts.app')
@section('breadcrumb', 'Dashboard')
{{-- @section('title', 'Dashboard') --}}

@section('content')
    <div class="container-fluid py-3">
        @if ($jadwal)
            <div class="card border-0 shadow-sm mb-4" style="border-left: 5px solid #5e72e4 !important; border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary-soft text-primary uppercase shadow-none font-weight-bold"
                                    style="font-size: 0.7rem; letter-spacing: 1px;">
                                    JADWAL WAWANCARA TERDEKAT
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">
                                {{ $jadwal->namaMahasiswa }}
                            </h4>
                        </div>

                        <div class="col-md-4 mt-3 mt-md-0 border-start-md">
                            <div class="ps-md-4">
                                <div class="d-flex align-items-center mb-2 text-dark">
                                    <div class="icon-shape icon-xs bg-dark rounded-circle me-2 d-flex align-items-center justify-content-center"
                                        style="width: 30px; height: 30px;">
                                        <i class="material-symbols-rounded" style="font-size: 0.8rem;">calendar_month</i>
                                    </div>
                                    <span class="small fw-600">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center text-dark">
                                    <div class="icon-shape icon-xs bg-dark rounded-circle me-2 d-flex align-items-center justify-content-center"
                                        style="width: 30px; height: 30px;">
                                        <i class="material-symbols-rounded"
                                            style="font-size: 0.8rem;">nest_clock_farsight_analog</i>
                                    </div>
                                    <span class="small fw-600">
                                        {{ $jadwal->mulai }} - {{ $jadwal->selesai }} WIB
                                    </span>
                                </div>
                                {{-- <div class="d-flex align-items-center mt-2 text-dark">
                                    <strong>Penilai:</strong> {{ $jadwal->penilaiStr ?? '-' }}
                                </div> --}}
                                @if ($jadwal->link && trim($jadwal->link) !== '')
                                    <a href="{{ $jadwal->link_wawancara }}" target="_blank" class="btn btn-primary mt-2">Join
                                        Wawancara</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-white">Belum ada jadwal wawancara terdekat yang Anda nilai.</div>
        @endif
    </div>
@endsection
