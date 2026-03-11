@extends('layouts.app')
@section('breadcrumb', 'Detail Kandidat')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Detail Kandidat</h4>
            <span class="badge bg-info text-white px-3 py-2 rounded-pill">
                {{ $detailKandidat->statusPendaftaran }}
            </span>
        </div>
        {{-- ini untuk detail kandidat (kiri) --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-white py-2" style="border-bottom: 1px solid #e2e8f0;">
                        <h6 class="mb-0 fw-semibold">Informasi Kandidat</h6>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong class="text-dark">Nama: </strong>
                                    <span class="text-dark">
                                        {{ $detailKandidat->namaMahasiswa }}
                                    </span>
                                </div>

                                <div class="mb-2">
                                    <strong class="text-dark">Fakultas: </strong>
                                    <span class="text-dark">
                                        {{ $detailKandidat->fakultas }}
                                    </span>
                                </div>

                                <div class="mb-2">
                                    <strong class="text-dark">Lowongan: </strong>
                                    <span class="text-dark">
                                        {{ $detailKandidat->judulLowongan }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong class="text-dark">NRP: </strong>
                                    <span class="text-dark">
                                        {{ $detailKandidat->nrp }}
                                    </span>
                                </div>

                                <div class="mb-2">
                                    <strong class="text-dark">Tanggal Daftar: </strong>
                                    <span class="text-dark">
                                        {{ \Carbon\Carbon::parse($detailKandidat->tanggalDaftar)->translatedFormat('d M Y') }}
                                    </span>
                                </div>

                                <div class="mb-2">
                                    <strong class="text-dark">Status: </strong>
                                    <span class="text-dark">
                                        {{ $detailKandidat->statusPendaftaran }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- jawaban formulir --}}
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-white py-2" style="border-bottom: 1px solid #e2e8f0;">
                        <h6 class="mb-0 fw-semibold">Jawaban Formulir</h6>
                    </div>
                    <div class="card-body py-3">
                        @forelse ($jawabanFormulir as $jawaban)
                            <div class="mb-3">
                                <div class="fw-semibold text-dark mb-1">
                                    {{ $jawaban->namaField }}
                                </div>

                                <div class="bg-light p-2 rounded small">
                                    {{ $jawaban->jawaban }}
                                </div>
                            </div>
                        @empty
                            <div class="text-muted">
                                Belum ada jawaban formulir
                            </div>
                        @endforelse
                    </div>
                </div>
                {{-- berkas pendaftaran --}}
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-white py-2" style="border-bottom: 1px solid #e2e8f0;">
                        <h6 class="mb-0 fw-semibold">Berkas Pendaftaran</h6>
                    </div>
                    <div class="card-body py-3">
                        @forelse ($berkasPendaftaran as $berkas)
                            <div class="border rounded px-2 py-2 mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>

                                        <a href="{{ asset('storage/' . $berkas->filePath) }}" target="_blank"
                                            class="text-decoration-underline fw-medium text-info">
                                            {{ $berkas->namaFile }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-muted">
                                Tidak ada berkas yang diupload
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            {{-- ini buat progress tahapan ->kanan --}}
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="card-header bg-white py-2" style="border-bottom: 1px solid #e2e8f0;">
                            <h6 class="mb-0 fw-semibold">Progress Tahap Rekrutmen</h6>
                        </div>
                        @if ($detailKandidat->statusPendaftaran == 'terdaftar')
                            <form action="{{ route('kandidat.proses', $detailKandidat->idPendaftaran) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
                                    Mulai Proses Kandidat
                                </button>
                            </form>
                        @endif

                        <div class="timeline-pro-unit">
                            @foreach ($tahapan as $tahap)
                                <div class="timeline-item-pro-unit">
                                    <span
                                        class="bullet-pro-unit
                                                @if ($tahap->status == 'Lulus') bullet-success
                                                @elseif ($tahap->status == 'Gagal') bullet-danger
                                                @elseif ($tahap->status == 'Proses') bullet-warning
                                                @else bullet-waiting @endif"></span>

                                    <h6 class="fw-bold mb-1">
                                        {{ $tahap->name }}
                                    </h6>

                                    <small class="text-muted">
                                        Status: {{ $tahap->status }}

                                        @if ($tahap->updated_at)
                                            • {{ \Carbon\Carbon::parse($tahap->updated_at)->translatedFormat('d M Y') }}
                                        @endif
                                    </small>

                                    @if ($tahap->catatan)
                                        <div class="mt-2 small text-muted">
                                            Catatan: {{ $tahap->catatan }}
                                        </div>
                                    @endif

                                    @if ($tahap->status == 'Proses')
                                        <div class="mt-2">
                                            <form method="POST" class="mb-0">
                                                @csrf
                                                <div class="mb-2">
                                                    <strong class="text-dark">Catatan: </strong>
                                                    <textarea name="catatan" class="form-control rounded-4 shadow-sm" rows="2"
                                                        placeholder="Masukkan catatan untuk tahap ini..."></textarea>
                                                </div>
                                                <div class="d-flex gap-2 flex-wrap">
                                                    <button type="button" class="btn btn-success btn-sm px-3 btn-confirm"
                                                        data-url="{{ route('kandidat.lulus', $tahap->id) }}"
                                                        data-type="lulus">
                                                        Lulus
                                                    </button>

                                                    <button type="button" class="btn btn-danger btn-sm px-3 btn-confirm"
                                                        data-url="{{ route('kandidat.gagal', $tahap->id) }}"
                                                        data-type="gagal">
                                                        Gagal
                                                    </button>

                                                    @if ($tahap->tipe_tahap == 'Wawancara')
                                                        <a href="{{ route('kandidat.wawancara',
                                                            ['idProgressTahapan' => $tahap->id, 'idPendaftaran' => $detailKandidat->idPendaftaran]) }}"
                                                            class="btn btn-info btn-sm px-3">
                                                            Set Wawancara
                                                        </a>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('successProses'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Diterima',
                    text: '{{ session('successProses') }}',
                    showConfirmButton: true,
                    timer: 2500,
                });
            });
        </script>
    @endif

    <script>
        $(document).on('click', '.btn-confirm', function(e) {
            e.preventDefault();

            let button = $(this);
            let form = button.closest('form');
            let url = button.data('url');
            let type = button.data('type');

            let titleText = (type === 'lulus') ? 'Yakin ingin meluluskan tahap ini?' :
                'Yakin ingin menggagalkan tahap ini?';
            Swal.fire({
                title: titleText,
                text: "Tindakan ini tidak dapat dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if (result.isConfirmed) {
                    form.attr('action', url);
                    form.submit();
                }

            });
        });
    </script>
@endpush
