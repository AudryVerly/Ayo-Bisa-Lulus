@extends('layouts.app')
@section('breadcrumb', 'List Tugas Student Employee')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">List Tugas Student Employee</h6>
                            <a href="{{ route('tugas.showcreate', $idUnit) }}"
                                class="btn bg-white text-dark border shadow-sm">
                                <i class="material-symbols-rounded text-sm align-middle text-success">add</i>
                                <span class="align-middle fw-bold">Tambah Tugas</span>
                            </a>
                        </div>
                    </div>

                    <div class="card-body" px-2 pb-2>
                        <div class="table-responsive p-0">
                            <table id="tablelistugas" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Nama Mahasiswa</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Nama Tugas</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Bobot Nilai</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Tenggat Pengumpulan</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Submit</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Progress Tugas</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">File</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $d)
                                        <tr>
                                            <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $d->namaMahasiswa }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $d->namaTugas }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $d->bobotNilai }}</td>
                                            <td class="text-sm" style="text-align: center;">{{ $d->tenggatPengumpulan }}
                                            <td class="text-sm" style="text-align: center;">
                                                {{ $d->tanggalPengumpulan ?? '-' }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    @if ($d->progressTugas == 'assigned')
                                                        <span class="badge bg-gradient-info text-white px-3 py-2">Di
                                                            Tugaskan</span>
                                                    @elseif ($d->progressTugas == 'inProgress')
                                                        <span
                                                            class="badge bg-gradient-warning text-white px-3 py-2">Proses</span>
                                                    @elseif ($d->progressTugas == 'submitted')
                                                        <span
                                                            class="badge bg-gradient-warning text-white px-3 py-2">Dikumpulkan</span>
                                                    @elseif ($d->progressTugas == 'revisi')
                                                        <span
                                                            class="badge bg-gradient-primary text-white px-3 py-2">Revisi</span>
                                                    @else
                                                        <span
                                                            class="badge bg-gradient-success text-white px-3 py-2">Selesai</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    @if ($d->statusPengumpulan == 'tepatwaktu')
                                                        <span class="badge bg-gradient-success text-white px-3 py-2">Tempat
                                                            Waktu</span>
                                                    @elseif ($d->statusPengumpulan == 'terlambat')
                                                        <span
                                                            class="badge bg-gradient-danger text-white px-3 py-2">Terlambat</span>
                                                    @else
                                                        <span
                                                            class="badge bg-gradient-secondary text-white px-3 py-2">Belum</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-sm" style="text-align: center;">
                                                @if ($d->file_path)
                                                    <a href="{{ asset('storage/' . $d->file_path) }}" target="_blank"
                                                        class="btn btn-sm bg-gradient-primary">
                                                        Lihat
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    @if ($d->progressTugas == 'submitted')
                                                        <button class="btn bg-gradient-success btn-sm text-white btn-nilai"
                                                            data-bs-toggle="modal" data-bs-target="#modalPenilaian"
                                                            data-idtugas="{{ $d->id }}"
                                                            data-idmahasiswa="{{ $d->idMahasiswa }}"
                                                            data-status="{{ $d->statusPengumpulan }}"
                                                            data-bobot="{{ $d->bobotNilai }}">
                                                            Nilai
                                                        </button>
                                                        <button class="btn bg-gradient-danger btn-sm text-white btn-revisi"
                                                            data-bs-toggle="modal" data-bs-target="#modalrevisi"
                                                            data-idtugas="{{ $d->id }}"
                                                            data-idmahasiswa="{{ $d->idMahasiswa }}">
                                                            Revisi
                                                        </button>
                                                    @elseif($d->progressTugas == 'revisi')
                                                        <span class="badge bg-warning">Revisi</span>
                                                    @elseif ($d->progressTugas == 'done')
                                                        <span class="badge bg-success">Sudah diNilai</span>
                                                    @else
                                                        <span class="badge bg-gradient-info text-white px-3 py-2">Belum
                                                            Dikerjakan</span>
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
    <div class="modal fade" id="modalPenilaian" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formpeniliantugas" method="POST" action="{{ route('tugas.simpanpenilaian') }}">
                    @csrf
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Kumpulkan Tugas</h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idTugas" id="idTugas">
                        <input type="hidden" name="idMahasiswa" id="idMahasiswa">
                        <div class="form-group mb-2">
                            <label for="nilaiAwal" class="form-label fw-bold text-secondary">Nilai</label>
                            <div class="custom-tooltip"
                                data-title="Masukkan nilai yang akan diberikan tidak boleh melebih bobot ">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <input type="number" id="nilaiAwal" name="nilaiAwal"
                                class="form-control border rounded-3 px-3 py-2" min="0">
                            <small id="infoNilaiAwal" class="text-muted">
                                Nilai tidak boleh melebihi bobot
                            </small>
                            @error('nilaiAwal')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="penalti" class="form-label fw-bold text-secondary">Penalti</label>
                            <div class="custom-tooltip"
                                data-title="Masukkan nilai penalti yang sesuai tidak boleh melebihi nilai bobot">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <input type="number" id="penalti" name="penalti"
                                class="form-control border rounded-3 px-3 py-2" min="0">
                            <small id="infoPenalti" class="text-muted">
                                Penalti hanya berlaku jika terlambat
                            </small>
                            @error('penalti')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="catatan" class="form-label fw-bold text-secondary">Catatan</label>
                            <div class="custom-tooltip"
                                data-title="Masukkan catatan penilaian mengenai tugas yang diberikan ini, wajib diisi">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <textarea name="catatan" id="catatan" rows="3" class="form-control border rounded-3 px-3 py-2"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label fw-bold text-secondary">Nilai Akhir</label>
                            <div class="custom-tooltip"
                                data-title="Nilai akhir dihitung otomatis berdasarkan nilai yang diberikan, penalti, dan bobot tugas.">
                                <i class="material-symbols-rounded text-secondary ms-1">info</i>
                            </div>
                            <div id="nilaiAkhir" class="form-control bg-light text-dark fw-bold text-center">
                                0
                            </div>
                            <small class="text-muted">
                                Nilai akhir dihitung dari: (Nilai - Penalti) × Bobot / 100
                            </small>
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

    {{-- ini buat tampilan revisi --}}
    <div class="modal fade" id="modalrevisi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formrevisi" method="POST" action="{{ route('tugas.revisitugas') }}">
                    @csrf
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Revisi Tugas </h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="idTugas" id="rev_idTugas">
                        <input type="hidden" name="idMahasiswa" id="rev_idMahasiswa">
                        <div class="form-group mb-2">
                            <label for="tenggatRevisi" class="form-label fw-bold text-secondary">Tenggat Revisi</label>
                            <div class="custom-tooltip"
                                data-title="Silahkan atur ulang tenggat untuk revisi,wajib untuk diisi">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <input type="date" name="tenggatRevisi" id="tenggatRevisi"
                                class="form-control border rounded-3 px-3 py-2">
                            <small class="text-muted">
                                Tenggat revisi adalah batas terakhir pengumpulan ulang
                            </small>
                        </div>

                        <div class="form-group mb-2">
                            <label for="tenggatRevisi" class="form-label fw-bold text-secondary">Catatan Revisi</label>
                            <div class="custom-tooltip"
                                data-title="Tuliskan secara lengkap revisi yang diberikan, wajib diisi">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <textarea name="catatanRevisi" id="catatanRevisi" rows="2" class="form-control border rounded-3 px-3 py-2"></textarea>
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

    <script>
        $(document).ready(function() {
            $('#tablelistugas').DataTable({
                order: [
                    [4, 'asc']
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    emptyTable: "Belum ada Tugas yang ditugaskan",
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

    <script>
        let bobotGlobal = 0;

        $(document).on('click', '.btn-nilai', function() {
            let idTugas = $(this).data('idtugas');
            let idMahasiswa = $(this).data('idmahasiswa');
            let status = $(this).data('status');
            let bobot = $(this).data('bobot');

            bobotGlobal = bobot;

            $('#idTugas').val(idTugas);
            $('#idMahasiswa').val(idMahasiswa);

            $('#nilaiAwal')
                .attr('min', 0)
                .attr('max', 100);

            $('#penalti').val(0);
            $('#nilaiAkhir').text('0');
            $('#catatan').val('');

            if (status === 'terlambat') {
                $('#penalti').prop('readonly', false)
                    .removeClass('bg-light text-muted');
            } else {
                $('#penalti').val(0)
                    .prop('readonly', true)
                    .addClass('bg-light text-muted');
            }

            $('#infoNilaiAwal').text('Nilai harus diisi dari 0 sampai 100');
            $('#infoPenalti').text('Penalti hanya berlaku jika terlambat');
        });

        //ini buat hitung nilai akhir
        $('#nilaiAwal, #penalti').on('input', function() {

            let nilaiAwal = parseFloat($('#nilaiAwal').val()) || 0;
            let penalti = parseFloat($('#penalti').val()) || 0;

            // batas nilai 0 - 100
            if (nilaiAwal > 100) {
                nilaiAwal = 100;
                $('#nilaiAwal').val(100);
            }

            if (nilaiAwal < 0) {
                nilaiAwal = 0;
                $('#nilaiAwal').val(0);
            }

            // penalti tidak boleh lebih dari nilai awal
            if (penalti > nilaiAwal) {
                penalti = nilaiAwal;
                $('#penalti').val(nilaiAwal);
            }

            if (penalti < 0) {
                penalti = 0;
                $('#penalti').val(0);
            }

            // rumus baru:
            // ((nilai - penalti) * bobot) / 100
            let nilaiBersih = nilaiAwal - penalti;

            let nilaiAkhir = (nilaiBersih * bobotGlobal) / 100;

            if (nilaiAkhir < 0) nilaiAkhir = 0;

            $('#nilaiAkhir').text(nilaiAkhir.toFixed(2));
        });

        $(document).on('click', '.btn-revisi', function() {
            let idTugas = $(this).data('idtugas');
            let idMahasiswa = $(this).data('idmahasiswa');

            $('#rev_idTugas').val(idTugas);
            $('#rev_idMahasiswa').val(idMahasiswa);

            $('#tenggatRevisi').val('');
            $('#catatanRevisi').val('');
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
