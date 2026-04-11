@extends('layouts.app')
@section('breadcrumb', 'List Kandidat Pengumuman')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                        <h6 class="text-white text-capitalize m-0">List Kandidat - {{ $judulLowongan ?? '-' }}</h6>
                        <button type="button" class="btn bg-white text-dark border shadow-sm btn-publish"
                            data-bs-toggle="modal" data-bs-target="#modaltambahpengumuman">
                            Publish Semua
                        </button>
                    </div>
                </div>

                <div class="card-body px-2 pb-2">
                    <div class="table-responsive p-0">
                        <table id="tableKandidatPengumuman" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">No</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Nama Kandidat</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Nomor Surat</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Surat</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Status</th>
                                    <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Tanggal Publish</th>
                                    {{-- <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                        style="text-align: center;">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengumuman as $index => $p)
                                    <tr>
                                        <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                        <td class="text-sm" style="text-align: center;">{{ $p->namaKandidat ?? '-' }}</td>
                                        <td class="text-sm" style="text-align: center;">{{ $p->nomor_surat ?? '-' }}</td>
                                        <td class="text-sm" style="text-align: center;">
                                            @if ($p->file_path)
                                                <a href="{{ asset('storage/' . $p->file_path) }}" target="_blank"
                                                    class="text-decoration-underline fw-medium text-info">
                                                    Lihat
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-sm" style="text-align: center;">
                                            @if ($p->status == 'Terima')
                                                <span class="badge bg-success px-3 py-2">Lolos</span>
                                            @else
                                                <span class="badge bg-danger px-3 py-2">Tolak</span>
                                            @endif
                                        </td>
                                        <td class="text-sm" style="text-align: center;">
                                            {{ $p->tanggal_publish ? \Carbon\Carbon::parse($p->tanggal_publish)->translatedFormat('d M Y') : '-' }}
                                        </td>
                                        {{-- <td class="text-sm" style="text-align: center;">
                                            @if ($p->is_publish == 0)
                                                <form action="" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="idPendaftaran"
                                                        value="{{ $p->idPendaftaran }}">

                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        Publish
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-success fw-bold">
                                                    Sudah Publish
                                                </span>
                                            @endif
                                        </td> --}}
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
                <form action="" method="POST" enctype="multipart/form-data">
                    <div>
                        <div
                            class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                            <h5 class="modal-title text-white">Tambah Berkas Pengumuman</h5>
                            <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="idLowongan" value="{{ $pengumuman[0]->idLowongan ?? '' }}">
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

    <script>
        $(document).ready(function() {
            $('#tableKandidatPengumuman').DataTable({
                language: {
                    emptyTable: "Belum ada kandidat",
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
