@extends('layouts.app')
@section('breadcrumb', 'Detail Nilai Kandidat')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="fw-bold mb-3">Detail Penilaian Kandidat</h4>
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-dark"><strong class="text-dark">Nama: </strong> {{ $kandidat->namaKandidat }}</p>
                        <p class="text-dark"><strong class="text-dark">Lowongan: </strong> {{ $kandidat->judulLowongan }}</p>
                        <p class="text-dark"><strong class="text-dark">Posisi: </strong> {{ $kandidat->posisiLowongan }}</p>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($penilaian as $p)
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white d-flex justify-content-between">
                    <strong>Penilai: {{ $p->namaPenilai }}</strong>
                    <span class="text-info fw-bold">
                        Total: {{ number_format($p->nilaiFinal, 2) }}
                    </span>
                </div>

                <div class="table_responsive">
                    <table class="table table-hover align-middle mb-0 text-center table-sm">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">No</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Nama Kriteria</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Nilai (1-5)</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Bobot Kriteria</th>
                                <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                    style="text-align: center;">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailKriteria[$p->idPenilaian] ?? [] as $index => $detail)
                                <tr>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">{{ $index + 1 }}
                                    </td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $detail->namaKriteria }}
                                    </td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $detail->nilaiAwal }}
                                    </td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $detail->bobotKriteria }}
                                    </td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $detail->nilaiAkhir }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    <small class="text-muted">
                        Catatan: {{ $p->catatan ?? '-' }}
                    </small>
                </div>
            </div>
        @endforeach
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h5 class="text-dark fw-bold"> Nilai Akhir Kandidat</h5>
                <h2 class="text-info fw-bold">
                    {{ number_format($summary->nilaiAkhir, 2) }}
                </h2>
                <p class="text-muted">
                    Berdasarkan {{ $summary->jumlahPenilai }} penilai
                </p>
            </div>
        </div>
    </div>
@endsection
