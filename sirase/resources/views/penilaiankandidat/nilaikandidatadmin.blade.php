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
                    @if (!$semuaDinilai)
                        <div class="alert alert-danger text-center mb-3 text-white">
                            Semua kandidat harus dinilai terlebih dahulu sebelum menentukan hasil.
                        </div>
                    @endif

                    <div class="alert alert-info text-center text-white">
                        Kuota diterima: {{ $jumlahDiterima }} / {{ $kuota }}
                    </div>

                    @if ($jumlahDiterima >= $kuota)
                        <div class="alert alert-primary text-center text-white">
                            Kuota sudah penuh. Ubah kandidat lain ke "Tolak" jika ingin mengganti.
                        </div>
                    @endif

                    @if ($kandidat->where('is_publish', 1)->count() > 0)
                        <div class="alert alert-success text-center text-white">
                            Pengumuman sudah dipublish. Data tidak dapat diubah.
                        </div>
                    @endif

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
                                        style="text-align: center;">Status</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Pengumuman</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kandidat as $index => $k)
                                    <tr>
                                        <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                        <td class="text-sm" style="text-align: center;">{{ $k->namaKandidat }}</td>
                                        <td class="text-sm" style="text-align: center;">{{ $k->jumlahPenilai }} /
                                            {{ $k->totalPenilai }}</td>
                                        <td class="text-sm" style="text-align: center;">
                                            @if ($k->jumlahPenilai == 0)
                                                <span class="badge bg-gradient-danger text-white px-3 py-2">Belum
                                                    dinilai</span>
                                            @else
                                                {{ $k->nilaiAkhir }}
                                            @endif
                                        </td>
                                        <td class="text-sm" style="text-align: center;">
                                            @if ($k->isLocked)
                                                <span class="badge bg-secondary">
                                                    Sudah diterima di lowongan lain
                                                </span>
                                            @elseif ($k->status == 'Terima')
                                                <span class="badge bg-success">Lolos</span>
                                            @elseif ($k->status == 'Tolak')
                                                <span class="badge bg-danger">Tolak</span>
                                            @else
                                                <span class="badge bg-dark">Belum Dipilih</span>
                                            @endif
                                        </td>
                                        <td class="text-sm" style="text-align: center;">
                                            @if ($k->isLocked)
                                                <span class="badge bg-secondary">Tidak Berlaku</span>
                                            @elseif (is_null($k->status))
                                                <span class="badge bg-dark">Belum Memilih</span>
                                            @elseif ($k->is_publish == 1)
                                                <span class="badge bg-info">Published</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">

                                                {{-- KALAU SUDAH PUBLISH --}}
                                                @if ($k->is_publish == 1)
                                                    <button class="btn bg-gradient-danger btn-sm text-white" disabled>
                                                        Sudah Publish
                                                    </button>

                                                    {{-- KALAU BELUM PUBLISH --}}
                                                @elseif ($semuaDinilai)
                                                    {{-- LOCKED --}}
                                                    @if (isset($k->isLocked) && $k->isLocked)
                                                        <button class="btn bg-gradient-secondary btn-sm text-white" disabled>
                                                            Tidak Bisa dipilih
                                                        </button>
                                                    @else
                                                        {{-- BELUM ADA STATUS --}}
                                                        @if (is_null($k->status))
                                                            <form action="{{ route('pengumuman.lolos') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="idPendaftaran"
                                                                    value="{{ $k->idPendaftaran }}">
                                                                <button class="btn bg-gradient-success btn-sm text-white"
                                                                    {{ $jumlahDiterima >= $kuota ? 'disabled' : '' }}>
                                                                    Lolos
                                                                </button>
                                                            </form>

                                                            <form action="{{ route('pengumuman.tolak') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="idPendaftaran"
                                                                    value="{{ $k->idPendaftaran }}">
                                                                <button class="btn bg-gradient-danger btn-sm text-white">
                                                                    Tolak
                                                                </button>
                                                            </form>
                                                        @endif

                                                        {{-- SUDAH TERIMA --}}
                                                        @if ($k->status == 'Terima')
                                                            <form action="{{ route('pengumuman.tolak') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="idPendaftaran"
                                                                    value="{{ $k->idPendaftaran }}">
                                                                <button class="btn btn-warning btn-sm">
                                                                    Ubah ke Tolak
                                                                </button>
                                                            </form>
                                                        @endif

                                                        {{-- SUDAH TOLAK --}}
                                                        @if ($k->status == 'Tolak')
                                                            <form action="{{ route('pengumuman.lolos') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="idPendaftaran"
                                                                    value="{{ $k->idPendaftaran }}">
                                                                <button class="btn btn-warning btn-sm text-white"
                                                                    {{ $jumlahDiterima >= $kuota ? 'disabled' : '' }}>
                                                                    Ubah ke Lolos
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                @else
                                                    <button class="btn btn-secondary btn-sm text-white" disabled>
                                                        Tunggu Penilaian
                                                    </button>
                                                @endif

                                                {{-- DETAIL SELALU ADA --}}
                                                <a href="{{ route('kandidatadmin.detailnilaikandidat', $k->idPendaftaran) }}"
                                                    class="btn bg-gradient-info btn-sm text-white">
                                                    Detail Nilai
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#tablelistkandidat').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    emptyTable: "Belum ada kandidat",
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

        $(document).on('submit', '.form-tolak', function(e) {
            e.preventDefault();
            let form = this;

            Swal.fire({
                title: 'Yakin?',
                text: "Kandidat akan ditandai sebagai ditolak",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
