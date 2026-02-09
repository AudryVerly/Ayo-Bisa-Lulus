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

        {{-- filter search --}}
        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="input-group input-group-outline">
                    <input type="text" class="form-control" id="searchLowongan" placeholder="Cari Lowongan">
                </div>
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
                    <div class="col-lg-4 col-md-6 col-sm-12 lowongan-item">
                        <div class="card job-card shadow-sm border-0 h-100">
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

                                    <a href="{{ route('pendaftaran.formulir',$low->id) }}" class="btn btn-outline-secondary" style="margin-bottom:0px;">
                                        Daftar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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
            });
        });
    </script>

    <script>
        function filterLowongan() {
            let keyword = $('#searchLowongan').val().toLowerCase()
            let unit = $('#filterUnit').val().toLowerCase()

            $('.lowongan-item').each(function() {
                //ini yang dipakai di keyword
                let judul = $(this).find('.judul-lowongan').text().toLowerCase()
                let cardUnit = $(this).find('.unit-lowongan').text().toLowerCase()

                //ini biar apakah dari lowongan ini ada kareba kita pakai nama lowongan
                let matchkeyword = judul.includes(keyword) || cardUnit.includes(keyword)

                let matchUnit = unit === '' || cardUnit.includes(unit)

                if(matchkeyword && matchUnit) {
                    $(this).show()
                } else {
                    $(this).hide()
                }

            });
        }

        $('#searchLowongan').on('keyup', filterLowongan)
        $('#filterUnit').on('change', filterLowongan)
    </script>
@endpush
