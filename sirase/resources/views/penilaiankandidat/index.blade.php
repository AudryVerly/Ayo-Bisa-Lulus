@extends('layouts.app')
@section('breadcrumb', 'List Kandidat Dinilai')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Penilaian Kandidat</h3>
                <small class="text-muted">Pilih Kandidat Untuk dinilai</small>
            </div>
        </div>

        <div class="row">
            @foreach ($kandidat as $k)
                @php
                    $now = \Carbon\Carbon::now();
                    $jadwal = \Carbon\Carbon::parse($k->tanggalWawancara);
                @endphp
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold">{{ $k->namaKandidat }}</h5>
                                @if ($k->status == 'terjadwal')
                                    <span class="badge bg-danger text-white">Belum Dinilai</span>
                                @else
                                    <span class="badge bg-success">Sudah Dinilai</span>
                                @endif
                            </div>
                            <p class="mb-1 text-muted">{{ $k->namaLowongan }}</p>
                            <small class="text-secondary">{{ $k->posisiLowongan }}</small>

                            <div class="mt-3 d-flex justify-content-end">
                                @if ($k->status == 'terjadwal')
                                    @if ($now->gte($jadwal))
                                        <a href="{{ route('penilaian.formMenilai', $k->id) }}" class="btn btn-success">
                                            Nilai
                                        </a>
                                    @else
                                        <button class="btn btn-secondary" disabled>
                                            Belum Waktunya
                                        </button>
                                    @endif
                                @else
                                    <a href="" class="btn btn-outline-success btn-sm">
                                        Lihat Hasil
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection