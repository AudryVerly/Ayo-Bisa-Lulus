@extends('layouts.app')
@section('breadcrumb', 'Kriteria Unit')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-0">Konfigurasi Kriteria Penilaian</h4>
                    <small class="text-muted">Pilih manimal 2 kriteria</small>
                </div>

                <span class="badge bg-info fs-6" id="counterKriteria">
                    {{ count($selected) }} 5 dipilih
                </span>
            </div>

            <div class="card-body">
                <div class="border rounded p-3 mb-4 bg-light">
                    <div class="row">
                        <div class="col-md-9">
                            <input type="text" class="form-control bg-white shadow-sm px-3 py-2" id="namaKriteria"
                                placeholder="masukkan nama kriteria">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success w-100" id="btnTambahKriteria">Tambah
                                Kriteria</button>
                        </div>
                        <small class="text-dark">Kriteria baru akan tersedia utuk seluruh Unit</small>
                    </div>
                </div>
                @if ($isLocked)
                    <div class="alert alert-danger text-white">
                        Tidak bisa mengubah kriteria karena lowongan sedang dalam proses (pendaftaran sudah ditutup dan
                        belum mulai kerja).
                    </div>
                @endif
                <form action="{{ route('kriteria.kriteriaunit') }}" method="POST">
                    @csrf
                    <div class="row" id="kriteriaContainer">
                        @foreach ($kriteria as $k)
                            @php
                                $checked = in_array($k->id, $selected);

                                //yang sudah pernah dipakai di bobot -> tidak boleh di uncentang
                                $locked = in_array($k->id, $lockedKriteria);
                            @endphp
                            <div class="col-md-4 mb-3">
                                <div
                                    class="cardUnit-checkbox {{ $checked ? 'checked' : '' }} {{ $locked ? 'border-success' : '' }}">
                                    <input type="checkbox" name="kriteria[]" value={{ $k->id }}
                                        {{ $checked ? 'checked' : '' }} data-locked="{{ $locked ? '1' : '0' }}">
                                    <label class="m-0">{{ $k->namaKriteria }}
                                        @if ($locked)
                                            <span class="badge bg-success ms-1">Sudah Digunakan</span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="text-end">
                        @if (!$kriteriaExists)
                            <button type="submit" class="btn btn-success" id="btnSimpan">
                                Simpan Pilihan
                            </button>
                        @endif
                    </div>
                </form>
                <div class="text-end">
                    @if ($kriteriaExists)
                        <button type="button" class="btn btn-danger" {{ $isLocked ? 'disabled' : '' }} id="btnReset">
                            Reset Kriteria
                        </button>
                    @endif
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="fw-bold mb-0">Kriteria Digunakan Unit</h5>
                        <small class="text-muted">Daftar kriteria yang sudah dipilih oleh unit ini</small>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align middle" id="kriteriaunitable"
                                class="table table-hover align-middle mb-0 text-center table-sm">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Nama Kriteria</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Bobot Nilai</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kriteriaUnit as $index => $kriteria)
                                        <tr class="{{ $kriteria->is_active == 0 ? 'table-secondary' : '' }}">
                                            <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                                {{ $kriteria->namaKriteria ?? '-' }}
                                            </td>
                                            <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                                {{ $kriteria->nilaiBobot ?? '-' }}
                                            </td>
                                            <td style="padding: 10px 16px; text-align: center;">
                                                @if ($kriteria->is_active == 1)
                                                    <span
                                                        class="badge bg-gradient-success text-white px-3 py-2">Aktif</span>
                                                @else
                                                    <span
                                                        class="badge bg-gradient-danger text-white px-3 py-2">Nonaktif</span>
                                                @endif
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
@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#kriteriaunitable').DataTable({
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

            let isLocked = @json($isLocked);
            //untuk mengecek limit kriteria masing masing unit
            function updateLimit() {

                let total = $('input[name="kriteria[]"]:checked').length

                $('#counterKriteria').text(total + ' dipilih')

                if (total < 2) {
                    $('#btnSimpan').prop('disabled', true);
                } else {
                    $('#btnSimpan').prop('disabled', false);
                }

                if (isLocked) {
                    $('#btnSimpan').prop('disabled', true)
                    return
                }
            }

            $('input[name="kriteria[]"]:checked').each(function() {
                $(this).closest('.cardUnit-checkbox').addClass('checked')
            })

            //ini dipakai kalau user tekan cardnya bukan checkboxnya
            $(document).on('click', '.cardUnit-checkbox', function(e) {

                if (isLocked) return;

                if (e.target.tagName === 'INPUT') return

                let cb = $(this).find('input');
                let locked = cb.data('locked');

                if (locked == 1 && cb.is(':checked')) {
                    return;
                }

                cb.prop('checked', !cb.prop('checked'))
                $(this).toggleClass('checked')

                updateLimit()
            })

            $(document).on('change', 'input[name="kriteria[]"]', function() {
                if (isLocked) {
                    $(this).prop('checked', !$(this).prop('checked'));
                    return;
                }

                let locked = $(this).data('locked');

                // kalau locked dan mau uncheck -> balikin
                if (locked == 1 && !$(this).is(':checked')) {
                    $(this).prop('checked', true);
                    return;
                }

                $(this).closest('.cardUnit-checkbox').toggleClass('checked')

                updateLimit()
            })

            $('#btnTambahKriteria').click(function() {

                let nama = $('#namaKriteria').val()

                $.ajax({
                    url: "{{ route('kriteria.storeKriteriaUnit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        namaKriteria: nama
                    },
                    success: function(res) {
                        if (!res.status) {
                            alert(res.message)
                            return
                        }

                        let html = `
                            <div class="col-md-4 mb-3">
                                <div class="cardUnit-checkbox checked">
                                    <input type="checkbox" name="kriteria[]" value="${res.id}" checked>
                                    <label class="m-0">${res.namaKriteria}</label>
                                </div>
                            </div>
                        `
                        $('#kriteriaContainer').append(html)

                        $('#namaKriteria').val('').focus()

                        updateLimit()
                    }
                })
            });

            $('#btnReset').click(function() {
                Swal.fire({
                    title: 'Reset kriteria?',
                    text: 'Semua kriteria akan dinonaktifkan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya reset'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('kriteria.reset') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire('Berhasil', res.message, 'success')
                                location.reload()
                            }
                        })
                    }
                })
            });

            updateLimit()
        })
    </script>
@endpush
