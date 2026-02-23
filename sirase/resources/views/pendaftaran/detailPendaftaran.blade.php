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
                                    DiTolak
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
                                {{-- ini nanyi kita isi tahapan --}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ini bagian detail --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">
                    <h5 class="fw-bold mb-3">Detail Pendaftaran</h5>
                    <div class="mb-2 d-flex">
                        <div style="width:160px;" class="fw-semibold">
                            Lowongan
                        </div>
                        <div class="text-dark fw-bold">
                            : {{ $pendaftaran->judulLowongan }}
                        </div>
                    </div>
                    <div class="mb-2 d-flex">
                        <div style="width:160px;" class="fw-semibold">
                            Posisi Lowongan
                        </div>
                        <div class="text-dark fw-bold">
                            : {{ $pendaftaran->posisiLowongan }}
                        </div>
                    </div>
                    <div class="mb-2 d-flex">
                        <div style="width:160px;" class="fw-semibold">
                            Unit Kerja:
                        </div>
                        <div class="text-dark fw-bold">
                            : {{ $pendaftaran->namaUnit }}
                        </div>
                    </div>
                    <div class="mb-2 d-flex">
                        <div style="width:160px;" class="fw-semibold">
                            Periode Kerja:
                        </div>
                        <div class="text-dark fw-bold">
                            : {{ \Carbon\Carbon::parse($pendaftaran->mulai)->translatedFormat('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($pendaftaran->akhir)->translatedFormat('d M Y') }}
                        </div>
                    </div>
                    <div class="mb-2 d-flex">
                        <div style="width:160px;" class="fw-semibold">
                            Durasi Kerja:
                        </div>
                        <div class="text-dark fw-bold">
                            : {{ $pendaftaran->durasi }} bulan
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 shadow-sm border-0 " style="border-radius: 16px;">
                    <h5 class="fw-bold mb-4">Progress Tahapan Seleksi</h5>
                    <div class="timeline-pro">
                        @foreach ($tahapan as $index => $tahap)
                            <div class="timeline-item-pro">
                                <div class="circle 
                                @if ($tahap->status == 'Lulus') circle-success
                                @elseif($tahap->status == 'Gagal')
                                    circle-danger
                                @elseif($tahap->status == 'Proses')
                                    circle-warning
                                @else
                                    circle-waiting @endif
                                ">
                                    <i class="material-symbols-rounded" style="font-size:16px;">
                                        @if ($tahap->status == 'Lulus')
                                            check
                                        @elseif($tahap->status == 'Gagal')
                                            close
                                        @elseif($tahap->status == 'Proses')
                                            schedule
                                        @else
                                            hourglass_empty
                                        @endif
                                    </i>
                                </div>
                                {{-- nanti aku pikirkan lagi tambahin catatan gak --}}
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold mb-1">
                                            Tahap{{ $index + 1 }} - {{ $tahap->name }}
                                        </h6>

                                        @if ($tahap->status == 'Lulus')
                                            <span class="badge bg-success">Lulus</span>
                                        @elseif($tahap->status == 'Gagal')
                                            <span class="badge bg-danger">Gagal</span>
                                        @elseif($tahap->status == 'Proses')
                                            <span class="badge bg-warning text-dark">Diproses</span>
                                        @else
                                            <span class="badge bg-secondary">Menunggu</span>
                                        @endif
                                    </div>

                                    <small class="text-muted">
                                        @if ($tahap->status == 'Lulus')
                                            Kamu telah lolos pada tahap ini
                                        @elseif($tahap->status == 'Gagal')
                                            Kamu tidak lolos pada tahap ini
                                        @elseif($tahap->status == 'Proses')
                                            Tahap ini sedang diproses oleh unit
                                        @else
                                            Menunggu proses seleksi dari unit
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
