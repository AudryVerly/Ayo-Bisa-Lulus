@extends('layouts.app')
@section('breadcrumb', 'Hasil Penilaian')

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                        <h6 class="text-white text-capitalize m-0">List Kandidat {{ $lowongan->judulLowongan }}</h6>
                    </div>
                </div>

                <div class="card-body px-2 pb-2">
                    <div class="table-responsive p-0">
                        <table id="tablelistkandidat" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center; width=60">Rank</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Nama Kandidat</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Jumlah Penilai</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Nilai Akhir</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kandidat as $index => $k)
                                    <tr>
                                        <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                        <td class="text-sm" style="text-align: center;">{{ $k->namaKandidat }}</td>
                                        <td class="text-sm" style="text-align: center;">{{ $k->jumlahPenilai }}</td>
                                        <td class="text-sm" style="text-align: center;">
                                            @if ($k->jumlahPenilai == 0)
                                                <span class="badge bg-gradient-danger text-white px-3 py-2">Belum
                                                    dinilai</span>
                                            @else
                                                {{ $k->nilaiAkhir }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="" class="btn bg-gradient-success btn-sm text-white">
                                                    Lolos
                                                </a>
                                                <a href="" class="btn bg-gradient-danger btn-sm text-white">
                                                    Tolak
                                                </a>
                                                <a href="{{ route('kandidatadmin.detailnilaikandidat',$k->idPendaftaran) }}" class="btn bg-gradient-info btn-sm text-white">
                                                    Detail Nilai
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">
                                            Belum ada kandidat
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
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
            $('#tablelistkandidat').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    paginate: {
                        previous: "<",
                        next: ">",
                    }
                },
                lengthMenu: [5, 10, 25, 50, 100],
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }]
            });
        });
    </script>
@endpush
