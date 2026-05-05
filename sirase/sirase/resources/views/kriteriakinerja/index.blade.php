@extends('layouts.app')
@section('breadcrumb', 'Kriteria Kinerja')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-0">Konfigurasi Kriteria Kinerja</h4>
                    <small class="text-muted">Pilih kriteria sesuai kebutuhan penilaian kinerja</small>
                </div>
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
                <form action="{{ route('kriteriakinerja.kriteriaKinerja') }}" method="POST">
                    <div class="row" id="kriteriaContainer">
                        @csrf
                        @foreach ($kriteria as $k)
                            @php
                                $checked = in_array($k->id, $selected);
                            @endphp
                            <div class="col-md-4 mb-3">
                                <div class="cardUnit-checkbox" {{ $checked ? 'checked' : '' }}">
                                    <input type="checkbox" name="kriteria[]" value="{{ $k->id }}"
                                        {{ $checked ? 'checked' : '' }}>
                                    <label class="m-0">{{ $k->namaKriteria }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="text-end">
                        <div class="text-end">
                            <button type="submit" class="btn btn-success" id="btnSimpan">
                                Simpan Pilihan
                            </button>

                            @if (count($kriteriaUnit) > 0)
                                <button type="button" class="btn btn-danger" id="btnReset">
                                    Reset Kriteria
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
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
                                            style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kriteriaUnit as $index => $kriteria)
                                        <tr class="{{ $kriteria->status == 0 ? 'table-secondary' : '' }}">
                                            <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="text-sm" style="padding: 10px 16px; text-align: center;">
                                                {{ $kriteria->nama }}
                                            </td>
                                            <td style="padding: 10px 16px; text-align: center;">
                                                @if ($kriteria->status == 1)
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

            function initChecked() {
                $('input[name="kriteria[]"]').each(function() {
                    if ($(this).is(':checked')) {
                        $(this).closest('.cardUnit-checkbox').addClass('checked');
                    } else {
                        $(this).closest('.cardUnit-checkbox').removeClass('checked');
                    }
                });
            }

            initChecked();


            // $('input[name="kriteria[]"]:checked').each(function() {
            //     $(this).closest('.cardUnit-checkbox').addClass('checked')
            // })

            $(document).on('change', 'input[name="kriteria[]"]', function() {
                if ($(this).is(':checked')) {
                    $(this).closest('.cardUnit-checkbox').addClass('checked');
                } else {
                    $(this).closest('.cardUnit-checkbox').removeClass('checked');
                }
            });

            //ini dipakai kalau user tekan cardnya bukan checkboxnya
            $(document).on('click', '.cardUnit-checkbox', function(e) {
                if (e.target.tagName === 'INPUT') return;

                let cb = $(this).find('input');
                cb.prop('checked', !cb.prop('checked')).trigger('change');
            });

            $('#btnTambahKriteria').click(function() {
                let nama = $('#namaKriteria').val()

                $.ajax({
                    url: "{{ route('kriteriakinerja.kriteriaUnit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        namaKriteria: nama
                    },
                    success: function(res) {
                        console.log(res);
                        if (!res.status) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: res.message,
                                confirmButtonText: 'OK'
                            })
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

                        initChecked();

                        $('#namaKriteria').val('').focus();
                    }
                })
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

            $('#btnReset').click(function() {
                Swal.fire({
                    title: 'Yakin reset?',
                    text: "Semua kriteria akan dinonaktifkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, reset!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('kriteriakinerja.resetkriteria') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                if (res.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: res.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload()
                                    })
                                }
                            }
                        })
                    }
                })
            })
        });
    </script>
@endpush
