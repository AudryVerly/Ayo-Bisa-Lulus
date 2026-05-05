@extends('layouts.app')
@section('breadcrumb', 'Dashboard')
{{-- @section('title', 'Dashboard') --}}

@section('content')
    <div class="container-fluid py-4">
        {{-- header --}}
        <div class="mb-4">
            <h4 class="fw-bold mb-1">Lowongan Student Employee Universitas Surabaya</h4>
            <p class="text-muted mb-0">
                Daftar Lowongan yang tesedia
            </p>
        </div>

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
                                {{ $jadwal->judulLowongan }}
                            </h4>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0 border-start-md">
                            <div class="ps-md-4">
                                <div class="d-flex align-items-center mb-2 text-dark">
                                    <div class="icon-shape icon-xs bg-dark rounded-circle me-2 d-flex align-items-center justify-content-center"
                                        style="width: 30px; height: 30px;">
                                        <i class="material-symbols-rounded" style="font-size: 0.8rem;">calendar_month</i>
                                    </div>
                                    <span
                                        class="small fw-600">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}</span>
                                </div>
                                <div class="d-flex align-items-center text-dark">
                                    <div class="icon-shape icon-xs bg-dark rounded-circle me-2 d-flex align-items-center justify-content-center"
                                        style="width: 30px; height: 30px;">
                                        <i class="material-symbols-rounded"
                                            style="font-size: 0.8rem;">nest_clock_farsight_analog</i>
                                    </div>
                                    <span class="small fw-600">{{ $jadwal->mulai }} - {{ $jadwal->selesai }} WIB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($tugasAktif->count() > 0)
            <div class="mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-header bg-info text-white fw-bold">
                        Tugas Student Employee
                    </div>

                    <div class="card-body">
                        @foreach ($tugasAktif as $t)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <div>
                                    <div class="fw-bold text-dark">{{ $t->namaTugas }}</div>
                                    <small class="text-dark">
                                        Deadline:
                                        {{ \Carbon\Carbon::parse($t->tenggatPengumpulan)->translatedFormat('d M Y') }}
                                    </small>
                                </div>

                                <span
                                    class="badge
                            @if ($t->progressTugas == 'assigned') bg-secondary
                            @elseif($t->progressTugas == 'inProgress') bg-warning
                            @else bg-danger @endif">
                                    {{ ucfirst($t->progressTugas) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- filter search --}}
        <div class="row mb-4 g-3">
            <div class="col-md-3 ">
                <input type="text" id="searchLowongan" placeholder="Cari Lowongan"
                    class="form-control border rounded-3 shadow-sm px-3 py-2">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control border rounded-3 shadow-sm px-3 py-2" id="searchKualifikasi"
                    placeholder="Cari Kualifikasi">
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-outline">
                    <select id="filterUnit" class="form-select shadow-sm border rounded-3 px-3 py-2">
                        <option value="">Semua Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ strtolower($unit->name) }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @if ($lowongan->count() > 0)
                @foreach ($lowongan as $low)
                    <div class="col-lg-4 col-md-6 col-sm-12 lowongan-item" data-kualifikasi="{{ $low->kualifikasi }}">
                        <div class="card job-card shadow-sm border-0 h-100">
                            {{-- ini buat poster
                            @if ($low->poster)
                                <img src="{{ asset('storage/' . $low->poster) }}" class="card-img-top"
                                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                            @else
                                {{-- <img src="{{ asset('template/img/noimage.jpg') }}" class="card-img-top"
                                    style="aspect-ratio: 16/9; object-fit: cover; width: 100%;"> --}}
                            {{-- <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                    style="height: 170px; background: linear-gradient(45deg, #f3f4f7, #e2e5e9);">
                                    <i class="ni ni-image text-secondary opacity-5" style="font-size: 3rem;"></i>
                                </div> --}}
                            {{-- @endif --}}
                            <div class="position-relative"
                                style="height: 250px; overflow: hidden; background-color: #f8f9fa;" data-bs-toggle="modal"
                                data-bs-target="#posterModal{{ $low->id }}">
                                @if ($low->poster)
                                    <div
                                        style="background-image: url('{{ asset('storage/' . $low->poster) }}'); 
                                    background-size: cover; background-position: center; 
                                    filter: blur(15px); opacity: 0.3; position: absolute; top: 0; left: 0; right: 0; bottom: 0;">
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center h-100 position-relative">
                                        <img src="{{ asset('storage/' . $low->poster) }}"
                                            style="max-height: 110%; max-width: 110%; object-fit: contain; transform: scale(1.3); box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer;">
                                    </div>
                                @else
                                    <div
                                        class="d-flex flex-column align-items-center justify-content-center h-100 text-muted opacity-5">
                                        <small class="fw-bold">NO POSTER AVAILABLE</small>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                @if ($low->status === 1)
                                    <span class="badge bg-success align-self-start mb-2">
                                        Aktif
                                    </span>
                                @endif
                                <h5 class="fw-semibold mb-1 judul-lowongan">
                                    {{ $low->judulLowongan }}
                                </h5>
                                <p class="text-muted mb-2 unit-lowongan">
                                    {{ $low->unitName }}
                                </p>

                                @if (!empty($low->batasPendaftaran))
                                    <small class="text-muted d-block mb-3">
                                        Pendaftaran sampai:
                                        <strong>
                                            {{ \Carbon\Carbon::parse($low->batasPendaftaran)->format('d M Y') }}
                                        </strong>
                                    </small>
                                @endif

                                <div class="mt-auto text-end">
                                    <button type="button" class="btn btndetail bg-gradient-info text-white"
                                        data-bs-toggle="modal" data-bs-target="#modaldetaillowongan"
                                        style="margin-bottom:0px;" data-id-lowongan="{{ $low->id }}">
                                        Detail
                                    </button>

                                    <a href="{{ route('pendaftaran.formulir', $low->id) }}" class="btn btn-outline-success"
                                        style="margin-bottom:0px;">
                                        Daftar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($low->poster)
                        <div class="modal fade" id="posterModal{{ $low->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h6 class="text-white">Poster Lowongan</h6>
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center p-0">
                                        <img src="{{ asset('storage/' . $low->poster) }}" class="img-fluid rounded shadow">
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-warning text-white text-center">
                        Tidak ada lowongan aktif saat ini.
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('modals')
    <div class="modal fade" id="modaldetaillowongan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                    <div>
                        <h5 class="modal-title text-white" id="modalJudul"></h5>
                        <small class="text-white-50">Detail Informasi Lowongan</small>
                    </div>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- <div class="mb-3 text-center">
                        <img id="modalPoster" src="" class="img-fluid rounded shadow-sm"
                            style="max-height:250px; object-fit:contain; display:none;">
                    </div> --}}
                    <div class="mb-2">
                        <strong>Posisi: </strong>
                        <span id="modalPosisi"></span>
                    </div>
                    <div class="mb-2">
                        <strong>Unit: </strong>
                        <span id="modalUnit"></span>
                    </div>

                    <div class="mb-2"><strong>Durasi Kerja:
                        </strong> <span id="modalDurasi">
                        </span> bulan
                    </div>

                    <div class="mb-2">
                        <strong>Batas Pendafatran: </strong>
                        <span id="modalBatasPendaftaran"></span>
                    </div>

                    <hr>

                    <div class="mb-2"><strong>Periode Kerja:</strong>
                        <span id="modalMulai"></span> - <span id="modalAkhir"></span>
                    </div>

                    <div class="mb-3">
                        <h6>Deskripsi:</h6>
                        <p id="modalDeskripsi"></p>
                    </div>
                    <div class="mb-3">
                        <h6>Kualifikasi</h6>
                        <ul id="modalKualifikasi"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('error'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pendaftaran Ditolak',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2500,
                });
            });
        </script>
    @endif

    @if (session('successMendaftar'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Diterima',
                    text: '{{ session('successMendaftar') }}',
                    showConfirmButton: false,
                    timer: 2500,
                });
            });
        </script>
    @endif
    <script>
        $(document).on('click', '.btndetail', function() {
            let id = $(this).data('idLowongan');

            //$('#modalKualifikasi').html('<li>Loading...</li>')

            $.get(`/detailLowongan/${id}/lowongan`, function(response) {
                $('#modalJudul').text(response.judulLowongan)
                $('#modalPosisi').text(response.posisiLowongan)
                $('#modalUnit').text(response.unitName)
                $('#modalDurasi').text(response.durasiKerja)
                $('#modalBatasPendaftaran').text(response.batasPendaftaran)
                $('#modalMulai').text(response.mulaiKerja)
                $('#modalAkhir').text(response.akhirKerja)
                $('#modalDeskripsi').text(response.deskripsi)

                $('#modalKualifikasi').empty()

                if (response.kualifikasi) {
                    response.kualifikasi.split('\n').forEach(item => {
                        $('#modalKualifikasi').append('<li>' + item + '</li>')
                    })
                } else {
                    $('#modalKualifikasi').append('<li>-</li>')
                }

                // if(response.poster){
                //     $('#modalPoster').attr('src','/storage/' + response.poster )
                //     $('#modalPoster').show()
                // }else{
                //     $('#modalPoster').hide()
                // }
            });
        });
    </script>

    <script>
        function filterLowongan() {
            let keyword = $('#searchLowongan').val().toLowerCase()
            let unit = $('#filterUnit').val().toLowerCase()
            let kualifikasiKeyword = $('#searchKualifikasi').val().toLowerCase()


            $('.lowongan-item').each(function() {
                //ini yang dipakai di keyword
                let judul = $(this).find('.judul-lowongan').text().toLowerCase()
                let cardUnit = $(this).find('.unit-lowongan').text().toLowerCase()
                let kualifikasi = $(this).data('kualifikasi').toLowerCase() || ''

                //ini biar apakah dari lowongan ini ada kareba kita pakai nama lowongan
                let matchkeyword = judul.includes(keyword) || cardUnit.includes(keyword)
                let matchKualifikasi = kualifikasi.includes(kualifikasiKeyword)
                let matchUnit = unit === '' || cardUnit.includes(unit)

                if (matchkeyword && matchUnit && matchKualifikasi) {
                    $(this).show()
                } else {
                    $(this).hide()
                }

            });
        }

        $('#searchLowongan').on('keyup', filterLowongan)
        $('#filterUnit').on('change', filterLowongan)
        $('#searchKualifikasi').on('keyup', filterLowongan)
    </script>
@endpush
