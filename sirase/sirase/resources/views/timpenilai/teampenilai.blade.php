@extends('layouts.app')
@section('breadcrumb', 'Tim Penilaian')

@section('content')
    <div class="container-fluid py-4">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                        <h6 class="text-white text-capitalize m-0">{{ $lowongan->judulLowongan }} - Tim Penilai
                        </h6>
                    </div>
                </div>
                <div class= "card-body bg-light" style="border-radius: 0 0 12px 12px;">
                    @foreach ($penilai as $pen)
                        <div class="field-card penilai-card p-3 mb-3 shadow-sm border rounded d-flex align-items-center gap-3 justify-content-between  {{ $pen->isActive == 0 ? 'field-disabled text-muted' : 'bg-white' }}"
                            data-id="{{ $pen->id }}">
                            <div class="d-flex align-items-center gap-3 flex-grow-1">
                                {{-- ini sementara pakai logo manusia dulu --}}
                                <div class ="bg-dark text-white d-flex justify-content-center align-items-center"
                                    style="width:45px;height:45px;border-radius:22px;font-size:18px;">
                                    <i class="material-symbols-rounded text-sm">person_2</i>
                                </div>

                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 d-flex align-items-center gap-2">{{ $pen->name }}</h6>
                                        @if ($pen->statusPenilaian == 'Sudah')
                                            <span class="badge bg-success bg-opacity-10 text-white">
                                                Sudah Menilai
                                            </span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-white">
                                                Belum Menilai
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <div class="tahap-toggle-switch">
                                    <input type="checkbox" id="toggle-{{ $pen->id }}" class="tahap-toggle-input"
                                        data-id="{{ $pen->id }}" {{ $pen->isActive == 1 ? 'checked' : '' }}>
                                    <label for="toggle-{{ $pen->id }}" class="tahap-toggle-label"></label>
                                </div>

                                <button type="button"
                                    class="btnedit btn btn-secondary btn-sm {{ $pen->isActive == 0 ? 'd-none' : '' }}"
                                    data-id-penilai="{{ $pen->id }}" data-id-staff-unit = "{{ $pen->idStaffUnit }}"
                                    data-status-penilaian = "{{ $pen->statusPenilaian }}"
                                    style="width:45px;height:45px;border-radius:12px;font-size:18px;" data-bs-toggle="modal"
                                    data-bs-target="#modaledittim">
                                    <i class="material-symbols-rounded text-sm">edit</i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                    <div>
                        <button class=" btn btn-outline-secondary btn-lg w-100 text-center py-3" data-bs-toggle="modal"
                            data-bs-target="#modaladdtim" data-id-lowongan={{ $lowongan->id }}>
                            <i class="material-symbols-rounded text-dark">add_2</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    <div class="modal fade" id="modaladdtim" tabindex="-1" aria-hidden = "true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('timPenilai.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idLowongan" id="idLowongan">
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Tambah Tim Penilai</h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label class="form-label fw-bold text-secondary">Pilih Staff: </label>
                            <select name="idStaffUnit" id="staffDropdown"
                                class="form-select shadow-sm border rounded-3 px-3 py-2">
                                <option value="" disabled selected>Pilih Staff</option>
                            </select>
                            @error('idStaffUnit')
                                <div class="text-danger" id="idStaffUnit">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaledittim" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="POST" id="formEditTim" method="POST">
                    @csrf
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Edit Tim Staff</h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idPenilai" id="idPenilai">
                        <div class="form-group mb-2">
                            <label class="form-label fw-bold text-secondary">Pilih Staff: </label>
                            <select name="idStaffUnit" id="staffDropdownEdit"
                                class= "form-select shadow-sm border rounded-3 px-3 py-2">
                                <option value="" disabled selected>Pilih Staff</option>
                            </select>
                            <div class="text-danger" id="errorIdStaffUnit"></div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label fw-bold text-secondary">Status Penilaian</label>
                            <select name="statusPenilaian" id="statusPenilaian"
                                class= "form-select shadow-sm border rounded-3 px-3 py-2">
                                <option value="Belum">Belum Menilai</option>
                                <option value="Sudah">Sudah Menilai</option>
                            </select>
                            <div class="text-danger" id="errorStatusPenilaian"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let oldStaffUnit = "{{ old('idStaffUnit') }}";

        $(document).on('click', '[data-bs-target="#modaladdtim"]', function() {
            let idLowongan = $(this).data('id-lowongan');

            //ini untuk input hidden
            $('#idLowongan').val(idLowongan);

            //ini untuk reset dropdown kalau misalnya modal ditekan
            $('#staffDropdown').html('<option value="" disabled selected>Pilih Staff</option>');

            $.ajax({
                url: "{{ route('timPenilai.showstaff') }}",
                method: 'GET',
                data: {
                    idLowongan: idLowongan
                },
                success: function(response) {
                    if (response.length == 0) {
                        $('#staffDropdown').append(
                            '<option value="" disabled selected>Tidak ada staff tersedia</option>'
                        );
                    } else {
                        //jadi ini bakal ngelooping item atau nama dari staffnya
                        //i = index, item= idStaffUnit yang bisa jadi id dan name sesuai yang udah ditentuak
                        $.each(response, function(i, item) {
                            let selected = oldStaffUnit == item.idStaffUnit ? 'selected' : '';
                            $('#staffDropdown').append(
                                `<option value="${item.idStaffUnit}" ${selected}> ${item.name}</option>`
                            );
                        });
                    }
                },
                error: function() {
                    alert('Gagal Memuat data Staff')
                }
            });
        });

        //ini untuk edit
        $(document).on('click', '.btnedit', function() {
            let id = $(this).data('idPenilai');
            let idStaffUnit = $(this).data('idStaffUnit');
            let statusPenilaian = $(this).data('statusPenilaian');

            $('#idPenilai').val(id);
            $('#statusPenilaian').val(statusPenilaian);
            $('#staffDropdownEdit').html('<option value="" disabled selected>Pilih Staff</option>');

            $.ajax({
                url: "{{ route('timPenilai.showstaffedit') }}",
                method: "GET",
                data: {
                    idLowongan: "{{ $lowongan->id }}",
                    idPenilai: id,
                },
                success: function(response) {

                    if (response.length == 0) {
                        $('#staffDropdownEdit').append(
                            '<option value="" disabled selected>Tidak ada staff tersedia</option>'
                        );
                    } else {
                        //jadi ini bakal ngelooping item atau nama dari staffnya
                        //i = index, item= idStaffUnit yang bisa jadi id dan name sesuai yang udah ditentuak
                        $.each(response, function(i, item) {
                            let selected = idStaffUnit == item.idStaffUnit ? 'selected' : '';
                            $('#staffDropdownEdit').append(
                                `<option value="${item.idStaffUnit}" ${selected}> ${item.name}</option>`
                            );
                        });
                    }
                },
                error: function() {
                    alert('Gagal Memuat data Staff')
                }
            });
        });

        $('#formEditTim').submit(function(e) {
            e.preventDefault();

            let id = $('#idPenilai').val();

            $.ajax({
                url: `/penilaian/${id}/update`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    idStaffUnit: $('#staffDropdownEdit').val(),
                    statusPenilaian: $('#statusPenilaian').val(),
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#modaledittim').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors || {};

                        if (errors.idStaffUnit) {
                            $('#errorIdStaffUnit').text(errors.idStaffUnit[0]);
                        }

                        if (errors.statusPenilaian) {
                            $('#errorStatusPenilaian').text(errors.statusPenilaian[0]);
                        }
                    } else if (xhr.responseJSON?.message) {
                        $('#errorGeneral').text(xhr.responseJSON.message);
                    }
                }
            });
        });

        $(document).on('change', '.tahap-toggle-input', function() {
            let checkbox = $(this);
            let id = checkbox.data('id');
            let isChecked = checkbox.is(':checked');

            let title = isChecked ? 'Aktifkan Penilai?' : 'Nonaktifkan Penilai?';
            let text = isChecked ? 'Penilai akan diaktifkan dan bisa melakukan penilaian.' :
                'Penilai akan dinonaktifkan dan tidak bisa menilai.';

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/penilaian/${id}/toggle`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            let card = $(`.penilai-card[data-id="${id}"]`);
                            let editBtn = card.find('.btnedit');

                            if (isChecked) {
                                card.removeClass('field-disabled text-muted').addClass(
                                    'bg-white');
                                editBtn.removeClass('d-none');
                            } else {
                                card.addClass('field-disabled text-muted').removeClass(
                                    'bg-white');
                                editBtn.addClass('d-none');
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function() {
                            checkbox.prop('checked', !isChecked);
                            Swal.fire('Error', 'Gagal mengubah status', 'error');
                        }
                    });
                } else {
                    //ini untuk cancel kalau gak jadi
                    checkbox.prop('checked', !isChecked);
                }

            });
        });

        $('#modaledittim , #modaladdtim').on('hidden.bs.modal', function() {
            //hapus pesan error
            $(this).find('.text-danger').text('');
            $(this).find('input:not([type=hidden])').val('');
        });

        @if ($errors->any())
            $(document).ready(function() {
                @if (old('idLowongan'))
                    $('#modaladdtim').modal('show');
                @endif

                @if (old('idPenilaian'))
                    $('#modaladdtim').modal('show');
                @endif
            });
        @endif
    </script>
@endpush
