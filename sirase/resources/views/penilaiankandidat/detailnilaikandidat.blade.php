@extends('layouts.app')
@section('breadcrumb', 'Detail Nilai Kandidat')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="fw-bold mb-3">Detail Penilaian Kandidat</h4>

                <div class="row">
                    <div class="col-md-6">
                        <p class="text-dark"><strong class="text-dark">Nama Kandidat:
                            </strong>{{ $dataKandidat->namaKandidat }}</p>
                        <p class="text-dark"><strong class="text-dark">Lowongan: </strong>{{ $dataKandidat->judulLowongan }}
                        </p>
                        <p class="text-dark"><strong class="text-dark">Posisi: </strong>{{ $dataKandidat->posisiLowongan }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-dark"><strong class="text-dark">Penilai: </strong>{{ $dataKandidat->namaPewawanacara }}
                        </p>
                        <p class="text-dark"><strong class="text-dark">Tanggal Wawancara:
                            </strong>{{ \Carbon\Carbon::parse($dataKandidat->tanggalWawancara)->translatedFormat('d F Y ') }}
                        </p>
                        <p class="text-dark"><strong class="text-dark">Status: </strong>
                            @if ($dataKandidat->status == 'sudah')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Belum Dinilai</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="card-header bg-white title fw-bold text-dark">
                    Nilai Per Kriteria
                </div>

                <div class="table-responsive">
                    <table id="tableNilai" class="table table-hover align-middle mb-0 text-center table-sm">
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
                            @foreach ($nilaiDetail as $index => $item)
                                <tr>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">{{ $index + 1 }}
                                    </td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $item->namaKriteria }}
                                    </td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $item->nilaiAwal }}
                                    </td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $item->bobot }}
                                    </td>
                                    <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                        {{ $item->nilaiAkhir }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h5 class="text-dark fw-bold"> Nilai Akhir Kandidat</h5>

                <h2 class="text-info fw-bold">
                    {{-- {{ $dataKandidat->nilaiFinal }} --}}
                    {{ number_format($dataKandidat->nilaiFinal ?? 0, 2) }}
                </h2>

                <p class="text-muted">
                    Catatan: {{ $dataKandidat->catatan ?? '-' }}
                </p>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tableNilai').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    paginate: {
                        previous: "<",
                        next: ">",
                    }
                },
                lengthMenu: [5, 10, 25, 50, 100],
                columnDefs: [
                    //ini supaya tabel index terakhir gak bisa disort
                    {
                        orderable: false,
                        targets: -1
                    }
                ]
            })
        });
    </script>
@endpush
