@extends('layouts.app')
@section('breadcrumb', 'Detail Lowongan')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            {{-- ini status pendaftaran --}}
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0" style="border-radius:16px;">
                    <div class="card-body d-flex align-items-center gap-3" style="min-height:100px;">
                        <div class ="bg-dark text-white d-flex justify-content-center align-items-center"
                            style="width:60px;height:60px;border-radius:30px;font-size:18px;">
                            <i class="material-symbols-rounded" style="font-size:28px;">description</i>
                        </div>

                        <div class="d-flex flex-column">
                            <small class="text-muted mb-1">Status Pendaftaran</small>
                            @if ($pendaftaran->statusPendaftaran == 'terdaftar')
                                <h5 class="fw-bold text-info mb-0">
                                    Terdaftar
                                </h5>
                            @elseif($pendaftaran->statusPendaftaran == 'diproses')
                                <h5 class="fw-bold text-warning mb-0">
                                    Diproses
                                </h5>
                            @elseif($pendaftaran->statusPendaftaran == 'diterima')
                                <h5 class="fw-bold text-success mb-0">
                                    Diterima
                                </h5>
                            @elseif($pendaftaran->statusPendaftaran == 'ditolak')
                                <h5 class="fw-bold text-danger mb-0">
                                    Ditolak
                                </h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- ini tanggal pendaftaran --}}
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0" style="border-radius:16px;">
                    <div class="card-body d-flex align-items-center gap-3" style="min-height:100px;">
                        <div class ="bg-warning text-white d-flex justify-content-center align-items-center"
                            style="width:60px;height:60px;border-radius:30px;font-size:18px;">
                            <i class="material-symbols-rounded" style="font-size:28px;">calendar_month</i>
                        </div>

                        <div class="d-flex flex-column">
                            <small class="text-muted mb-1">Tanggal daftar</small>
                            <h5 class="fw-bold text-dark mb-0">
                                {{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->translatedFormat('d M Y') }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ini tahap rekrutmen --}}
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0" style="border-radius:16px;">
                    <div class="card-body d-flex align-items-center gap-3" style="min-height:100px;">
                        <div class ="bg-success text-white d-flex justify-content-center align-items-center"
                            style="width:60px;height:60px;border-radius:30px;font-size:18px;">
                            <i class="material-symbols-rounded" style="font-size:28px;">task</i>
                        </div>

                        <div class="d-flex flex-column">
                            <small class="text-muted mb-1">Tahapan saat ini</small>
                            <h5 class="fw-bold text-dark mb-0">
                                @if ($tahapIni === null)
                                    <span class="badge bg-secondary">Belum Diproses</span>
                                @else
                                    <span class="badge bg-gradient-success">
                                        {{ $tahapIni }}
                                    </span>
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ini bagian detail --}}
        <div class="row align-items-start">
            <div class="col-lg-4 md-4">
                <div class="card p-3 shadow-sm border-0 h-100" style="border-radius: 16px;">
                    <h5 class="fw-bold mb-3">Detail Pendaftaran</h5>
                    <span class="detail-label">Lowongan</span>
                    <span class="detail-value">{{ $pendaftaran->judulLowongan }}</span>

                    <span class="detail-label">Posisi Lowongan</span>
                    <span class="detail-value">{{ $pendaftaran->posisiLowongan }}</span>

                    <span class="detail-label">Unit Kerja</span>
                    <span class="detail-value">{{ $pendaftaran->namaUnit }}</span>

                    <span class="detail-label">Periode Kerja</span>
                    <span class="detail-value">
                        {{ \Carbon\Carbon::parse($pendaftaran->mulai)->translatedFormat('d M Y') }} -
                        {{ \Carbon\Carbon::parse($pendaftaran->akhir)->translatedFormat('d M Y') }}
                    </span>

                    <span class="detail-label">Durasi Kerja</span>
                    <span class="detail-value">{{ $pendaftaran->durasi }} Bulan</span>
                </div>
            </div>
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 p-4" style="border-radius: 16px;">
                    <div class="mb-4">
                        <h5 class="fw-bold mb-1">Progress Tahapan Seleksi</h5>
                        <p class="text-muted small">Pantau terus perkembangan lamaran magang kamu di sini.</p>
                    </div>

                    <div class="timeline-pro">
                        @foreach ($tahapan as $tahap)
                            <div class="timeline-item-pro">
                                <div
                                    class="bullet-pro 
                                @if ($tahap->status == 'Lulus') bullet-success 
                                @elseif($tahap->status == 'Gagal') bullet-danger 
                                @elseif($tahap->status == 'Proses') bullet-warning 
                                @else bullet-waiting @endif">
                                </div>

                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold mb-1" style="font-size: 15px; color: #252f40;">
                                                {{ $tahap->name }}</h6>
                                            <p class="text-muted mb-0" style="font-size: 13px;">
                                                @if ($tahap->status == 'Lulus')
                                                    Selamat! Kamu lolos tahap ini.
                                                @elseif($tahap->status == 'Gagal')
                                                    Mohon maaf, kamu belum bisa lanjut.
                                                    @if (!empty($tahap->catatan))
                                                        <div class="text-danger mt-1" style="font-size: 12px;">
                                                            Alasan: {{ $tahap->catatan }}
                                                        </div>
                                                    @endif
                                                @elseif($tahap->status == 'Proses')
                                                    Sedang dalam peninjauan oleh tim terkait.
                                                @else
                                                    Menunggu Proses Rekrutmen
                                                @endif
                                            </p>
                                        </div>

                                        @if ($tahap->status == 'Lulus')
                                            <span class="badge bg-gradient-success" style="font-size: 10px;">LULUS</span>
                                        @elseif($tahap->status == 'Gagal')
                                            <span class="badge bg-gradient-danger" style="font-size: 10px;">GAGAL</span>
                                        @elseif($tahap->status == 'Proses')
                                            <span class="badge bg-gradient-warning" style="font-size: 10px;">DIPROSES</span>
                                        @else
                                            <span class="badge bg-light text-secondary border"
                                                style="font-size: 10px;">BELUM</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
