@extends('layouts.app')
@section('breadcrumb', 'Total Penilaian Kinerja')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4 g-3">
            <div class="col-md-3 ">
                <input type="text" id="searchKandidat" placeholder="Cari Mahasiswa"
                    class="form-control border rounded-3 shadow-sm px-3 py-2">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control border rounded-3 shadow-sm px-3 py-2" id="searchLowongan"
                    placeholder="Cari Lowongan">
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-outline">
                    <input type="text" class="form-control border rounded-3 shadow-sm px-3 py-2" id="searchUnit"
                        placeholder="Cari unit">
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($data as $d)
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card shadow-lg border-0 h-100 d-flex flex-column">
                        <div class="card-header bg-gradient-dark text-white">
                            <h6 class="mb-0 fw-bold text-white">
                                {{ $d->namaMahasiswa }}
                            </h6>
                            <small class="text-light">
                                {{ $d->judulLowongan }}
                            </small>
                        </div>
                        <div class="card-body py-4 text-center">
                            <small class="text-muted">Total Nilai</small>
                            <div class="display-4 fw-bold">
                                <h2 class="fw-bold text-info"> {{ $d->totalNilai }}</h2>
                            </div>
                            <div class="mt-2">
                                <span class="badge px-3 py-2 bg-success">
                                    {{ $d->kategori }}
                                </span>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted d-block">
                                    Unit: {{ $d->name }}
                                </small>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                            <button class="btn btn-primary w-100 rounded-pill btn-detail" data-bs-toggle="modal"
                                data-bs-target="#modal-{{ $d->idMahasiswa }}-{{ $d->idLowongan }}">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('modals')
    @foreach ($data as $d)
        <div class="modal fade" id="modal-{{ $d->idMahasiswa }}-{{ $d->idLowongan }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-dark text-white px-4 py-3 border-0">
                        <div>
                            <h5 class="modal-title text-white mb-1">
                                Detail Kinerja
                            </h5>

                            <small class="text-light">
                                {{ $d->namaMahasiswa }}
                            </small>
                        </div>

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body px-4 py-4">

                        <div class="mb-3">
                            <p class="mb-1 text-dark">
                                <strong>Lowongan:</strong>
                                {{ $d->judulLowongan }}
                            </p>

                            <p class="mb-2 text-dark">
                                <strong>Unit:</strong>
                                {{ $d->name }}
                            </p>

                            <span class="badge bg-success px-3 py-2">
                                {{ $d->kategori }}
                            </span>
                        </div>
                        <hr>
                        @forelse ($d->detail as $t)
                            <div class="border rounded-4 p-3 mb-3 bg-light">

                                <h6 class="fw-bold mb-3 text-dark">
                                    {{ $t->namaTugas }}
                                </h6>

                                <div class="row g-2">

                                    <div class="col-md-4">
                                        <small class="text-muted d-block">
                                            Nilai Awal
                                        </small>

                                        <span class="fw-bold fs-6 text-dark">
                                            {{ $t->nilaiAwal ?? '-' }}
                                        </span>
                                    </div>

                                    <div class="col-md-4">
                                        <small class="text-muted d-block">
                                            Penalti
                                        </small>

                                        <span class="fw-bold text-danger fs-6">
                                            {{ $t->penalti ?? '-' }}
                                        </span>
                                    </div>

                                    <div class="col-md-4">
                                        <small class="text-muted d-block">
                                            Nilai Akhir
                                        </small>

                                        <span class="fw-bold text-primary fs-6">
                                            {{ $t->nilaiAkhir ?? '-' }}
                                        </span>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <small class="text-muted d-block">
                                            Catatan
                                        </small>

                                        <div class="fw-semibold text-dark">
                                            {{ $t->catatan ?? '-' }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                Belum ada tugas dinilai
                            </div>
                        @endforelse
                        <hr>

                        <div class="text-end">
                            <h5 class="mb-0 fw-bold text-info">
                                Rata-rata : {{ number_format($d->totalNilai, 0) }}
                            </h5>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            function filterData() {

                let kandidat = $('#searchKandidat').val().toLowerCase().trim();
                let lowongan = $('#searchLowongan').val().toLowerCase().trim();
                let unit = $('#searchUnit').val().toLowerCase().trim();

                $('.col-md-6.col-xl-4.mb-4').each(function() {

                    let card = $(this);

                    let namaMahasiswa = card.find('.card-header h6').text().toLowerCase().trim();

                    let namaLowongan = card.find('.card-header small').text().toLowerCase().trim();

                    let namaUnit = card.find('.card-body .text-muted.d-block')
                        .text()
                        .replace('unit:', '')
                        .replace('Unit:', '')
                        .toLowerCase()
                        .trim();

                    let cocokMahasiswa = namaMahasiswa.includes(kandidat);
                    let cocokLowongan = namaLowongan.includes(lowongan);
                    let cocokUnit = namaUnit.includes(unit);

                    if (cocokMahasiswa && cocokLowongan && cocokUnit) {
                        card.show();
                    } else {
                        card.hide();
                    }

                });

            }

            $('#searchKandidat').on('keyup', filterData);
            $('#searchLowongan').on('keyup', filterData);
            $('#searchUnit').on('keyup', filterData);
        });
    </script>
@endpush
