@extends('layouts.app')
@section('breadcrumb', 'List Tugas')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">List Tugas Student Employee</h6>
                        </div>
                    </div>
                    <div class="card-body px-2 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tableListTugas" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Tugas</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Tenggat Pegumpulan</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Tenggat Revisi</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Tanggal Pengumpulan</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status Tugas</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Detail</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tugas as $index => $t)
                                        <tr>
                                            <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $t->namaTugas }}</td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ \Carbon\Carbon::parse($t->tenggatPengumpulan)->translatedFormat('d F Y ') }}
                                            </td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $t->tenggatRevisi ? \Carbon\Carbon::parse($t->tanggalPengumpulan)->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $t->tanggalPengumpulan ? \Carbon\Carbon::parse($t->tanggalPengumpulan)->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $t->statusPengumpulan ?? '-' }}</td>
                                            <td class="text-sm text-center">
                                                @if ($t->progressTugas == 'assigned')
                                                    <span class="badge bg-secondary">Belum Dikerjakan</span>
                                                @elseif ($t->progressTugas == 'inProgress')
                                                    <span class="badge bg-warning">Sedang Dikerjakan</span>
                                                @elseif ($t->progressTugas == 'submitted')
                                                    <span class="badge bg-info">Menunggu Penilaian</span>
                                                @elseif ($t->progressTugas == 'revisi')
                                                    <span class="badge bg-danger">Perlu Revisi</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td class="text-sm" style="text-align: center;">
                                                <button type="button" class="btn btn-sm bg-gradient-info text-white"
                                                    data-bs-toggle="modal" data-bs-target="#detailModal{{ $t->idTugas }}">
                                                    Detail Tugas
                                                </button>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    @if ($t->progressTugas == 'assigned')
                                                        <form
                                                            action="{{ route('tugasmahasiswa.updateprogress', $t->idTugas) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button class="btn btn-sm bg-gradient-warning text-white">
                                                                Proses
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if ($t->progressTugas == 'inProgress')
                                                        <button type="button"
                                                            class="btn bg-success text-white border shadow-sm btn-submit"
                                                            data-bs-toggle="modal" data-bs-target="#modaladdtugas"
                                                            data-id="{{ $t->idTugas }}">
                                                            Submit
                                                        </button>
                                                    @endif

                                                    @if ($t->progressTugas == 'revisi')
                                                        <button type="button" class="btn bg-danger text-white btn-submit"
                                                            data-bs-toggle="modal" data-bs-target="#modaladdtugas"
                                                            data-id="{{ $t->idTugas }}">
                                                            Upload Revisi
                                                        </button>
                                                    @endif

                                                    @if($t->progressTugas == 'submitted')
                                                        <span class="badge bg-success">Sudah diKumpulkan</span>
                                                    @elseif ($t->progressTugas == 'done')
                                                        <span class="badge bg-success">Sudah diNilai</span>
                                                    @endif
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
    </div>
@endsection
@push('modals')
    @foreach ($tugas as $t)
        <div class="modal fade" id="detailModal{{ $t->idTugas }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Detail Tugas </h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-3 border rounded mb-3">
                            <small class="text-muted">Staff Pemberi Tugas</small>
                            <div class="fw-bold">{{ $t->namaUser }}</div>
                        </div>

                        <div class="p-3 border rounded mb-3">
                            <small class="text-muted">Nama Tugas</small>
                            <div class="fw-bold">{{ $t->namaTugas }}</div>
                        </div>

                        <div class="p-3 border rounded mb-3">
                            <small class="text-muted">Deskripsi</small>
                            <div>{{ $t->deskripsi }}</div>
                        </div>

                        <div class="p-3 border rounded mb-3">
                            <small class="text-muted">Deadline</small>
                            <div class="fw-bold text-danger">
                                {{ \Carbon\Carbon::parse($t->tenggatPengumpulan)->translatedFormat('d F Y') }}
                            </div>
                        </div>
                        @if ($t->progressTugas == 'revisi')
                            <div class="p-3 border rounded bg-danger text-white">
                                <small>Catatan Revisi</small>
                                <div>{{ $t->catatanRevisi }}</div>

                                <small>
                                    Tenggat Revisi:
                                    {{ \Carbon\Carbon::parse($t->tenggatRevisi)->translatedFormat('d F Y') }}
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- modal buat submit hasil kerjaan --}}
    <div class="modal fade" id="modaladdtugas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formSubmitTugas" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Kumpulkan Tugas</h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="tugas" class="form-label fw-bold text-secondary">Upload Tugas</label>
                            <div class="custom-tooltip"
                                data-title="Masukkan file tugas dalam bentuk pdf,jpg,jpeg,png atau excel">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <div id="previewContainer" class="mt-3 text-center" style="display: none;">
                                <img id="previewImage" src="" class="img-fluid rounded shadow-sm"
                                    style="max-height: 200px;">
                                <small class="text-muted d-block mt-1">Preview Gambar</small>
                            </div>
                            <input type="file" id="tugas" name="tugas"
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
            $('#tableListTugas').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    emptyTable: 'Belum ada Lowongan',
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

            $('#tugas').on('change', function() {
                let file = this.files[0];

                if (!file) {
                    $('#previewContainer').hide();
                    return;
                }

                let fileType = file.type;

                if (fileType.startsWith('image/')) {
                    let reader = new FileReader();

                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result);
                        $('#previewContainer').fadeIn();
                    };

                    reader.readAsDataURL(file);

                } else {
                    $('#previewContainer').fadeOut();
                }
            });
        });

        $(document).on('click', '.btn-submit', function() {
            let idTugas = $(this).data('id');

            $('#idTugas').val(idTugas);

            let url = "/tugasmahasiswa/submitugas/" + idTugas;
            $('#formSubmitTugas').attr('action', url);
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    </script>
@endpush
