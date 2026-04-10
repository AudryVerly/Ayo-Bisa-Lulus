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
                                            @if ($k->status == 'Terima')
                                                <span class="badge bg-success">Lolos</span>
                                            @elseif ($k->status == 'Tolak')
                                                <span class="badge bg-success">Lolos</span>
                                            @else
                                                <span class="badge bg-dark">Belum Dipilih</span>
                                            @endif
                                        </td>
                                        <td class="text-sm" style="text-align: center;">
                                            @if (is_null($k->status))
                                                <span class="badge bg-dark">Belum Memilih</span>
                                            @elseif ($k->is_publish == 1)
                                                <span class="badge bg-info">Published</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                @if ($semuaDinilai)
                                                    {{-- Kalau BELUM ADA STATUS --}}
                                                    @if (is_null($k->status))
                                                        <button type="button"
                                                            class="btn bg-gradient-success btn-sm text-white btn-lolos"
                                                            data-bs-toggle="modal" data-bs-target="#modaltambahpengumuman"
                                                            data-idpendaftaran="{{ $k->idPendaftaran }}"
                                                            {{ $jumlahDiterima >= $kuota ? 'disabled' : '' }}>
                                                            Lolos
                                                        </button>

                                                        <form action="{{ route('pengumuman.tolak') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="idPendaftaran"
                                                                value="{{ $k->idPendaftaran }}">
                                                            <button type="submit"
                                                                class="btn bg-gradient-danger btn-sm text-white">
                                                                Tolak
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- Kalau SUDAH TERIMA --}}
                                                    @if ($k->status == 'Terima')
                                                        <form action="{{ route('pengumuman.tolak') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="idPendaftaran"
                                                                value="{{ $k->idPendaftaran }}">
                                                            <button type="submit" class="btn btn-warning btn-sm">
                                                                Ubah ke Tolak
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- Kalau SUDAH TOLAK --}}
                                                    @if ($k->status == 'Tolak')
                                                        <button type="button"
                                                            class="btn btn-warning btn-sm text-white btn-lolos"
                                                            data-bs-toggle="modal" data-bs-target="#modaltambahpengumuman"
                                                            data-idpendaftaran="{{ $k->idPendaftaran }}"
                                                            {{ $jumlahDiterima >= $kuota ? 'disabled' : '' }}>
                                                            Ubah ke Lolos
                                                        </button>
                                                    @endif
                                                @else
                                                    <button class="btn btn-secondary btn-sm text-white" disabled>
                                                        Tunggu Penilaian
                                                    </button>
                                                @endif

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
@push('modals')
    <div class="modal fade" id="modaltambahpengumuman" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('pengumuman.lolos') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <div
                            class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                            <h5 class="modal-title text-white">Tambah Pengumuman</h5>
                            <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="idPendaftaran" id="idPendaftaran">
                            <div class="form-group mb-2">
                                <label for="nomorSurat" class="form-label fw-bold text-secondary">Nomor Surat</label>
                                <div class="custom-tooltip"
                                    data-title="nomor surat dapat berupa nomor ST ataupun nomor surat pernyataan lolos bagi studentemployee">
                                    <i class="material-symbols-rounded text-secondary ms-1"
                                        style="font-size: 1rem;">info</i>
                                </div>
                                <input type="text" id="nomorSurat" name="nomorSurat"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2">
                                @error('nomorSurat')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="filePath" class="form-label fw-bold text-secondary">Surat ST/Surat
                                    Pernyataan</label>
                                <div class="custom-tooltip"
                                    data-title="Masukkan surat dalam bentuk PDF maksimal 20 MB,Surat dapat berupa ST atau keterangan lolos">
                                    <i class="material-symbols-rounded text-secondary ms-1"
                                        style="font-size: 1rem;">info</i>
                                </div>
                                <input type="file" id="surat" name="surat"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2">
                                @error('file_path')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-success text-white px-4">
                                    <i class="material-symbols-rounded text-sm">save</i><span
                                        class="align-middle">&nbsp;&nbsp;Simpan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
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

        $(document).on('click', '.btn-lolos', function() {
            let idPendaftaran = $(this).data('idpendaftaran');

            $('#idPendaftaran').val(idPendaftaran);
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
