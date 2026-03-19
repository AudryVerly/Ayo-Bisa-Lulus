@extends('layouts.app')
@section('breadcrumb', 'Kelola Tahapan Rekrutmen')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            {{-- Card Header Utama --}}
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">{{ $lowongan->judulLowongan }} - Tahapan Rekrutmen
                            </h6>
                            <div class="d-flex gap-2">
                                <button class="btn bg-white text-dark border shadow-sm" data-bs-toggle="modal"
                                    data-bs-target="#modaladdtahapan" data-id-lowongan="{{ $lowongan->id }}"
                                    {{ now()->gt($lowongan->batasPendaftaran) ? 'disabled' : '' }}>
                                    <i class="material-symbols-rounded text-sm align-middle text-success">add</i>
                                    <span class="align-middle fw-bold">Tambah Tahapan</span>
                                </button>
                                @if ($checkFormulir == 0)
                                    <a href="{{ route('formulir.manage', $lowongan->id) }}"
                                        class="btn bg-gradient-info text-white shadow-sm" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Set pertanyaan formulir,field formulir belum diset"
                                        style="font-size: 1rem; cursor: help;">
                                        <span class="align-middle fw-bold">Tambah formulir</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-2">
                        <div class="row mt-3 d-flex h-100 align-items-stretch">
                            {{-- ini untuk sisi kiri/daftar tahapan rekrutmen --}}
                            <div class="col-md-7 mb-4">
                                <div class="card shadow-lg border-radius-xl h-100 overflow-hidden p-0">
                                    <div class="card-header p-4 d-flex justify-content-between align-items-center"
                                        style="background: #212833; border-radius: 0.75rem 0.75rem 0 0;">
                                        <div class="d-flex flex-column">
                                            <h5 class="m-0 text-white">Tahapan Rekrutmen</h5>
                                            <p class="text-sm text-white-50 m-0">Aktifkan atau ubah alur tahapan</p>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div id ="listTahapan" class="d-flex flex-column gap-3 rounded">
                                            @foreach ($tahapan as $tahap)
                                                <div class="tahapCard d-flex justify-content-between align-items-center w-100 p-3 rounded"
                                                    style="background:#f7f6f6ee; border-left:5px; box-shadow:0 4px 12px rgba(0,0,0,0.08); border-radius:12px; border:1px solid rgb(118, 113, 113);">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span
                                                            class="tahapurutan badge rounded-circle bg-dark p-3 d-flex justify-content-center align-items-center"
                                                            style="width: 36px; height: 36px; font-size: 0.9rem; ">
                                                            {{ $tahap->urutan }}
                                                        </span>
                                                        <div class="d-flex flex-column">
                                                            <strong style="font-size: 0.95rem;" class="tahapname">
                                                                {{ $tahap->name }}
                                                            </strong>
                                                            <small class="text-info fw-semibold">
                                                                Tipe: {{ $tahap->tipe_tahap }}
                                                            </small>
                                                            @if ($tahap->status == 1)
                                                                <small class="text-secondary d-block">
                                                                    Aktif
                                                                </small>
                                                            @else
                                                                <small class="text-secondary d-block">
                                                                    Non-Aktif
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="tahap-toggle-switch">
                                                            <input type="checkbox" id="toggle-{{ $tahap->id }}"
                                                                class="tahap-toggle-input" data-id="{{ $tahap->id }}"
                                                                {{ $tahap->status == 1 ? 'checked' : '' }}
                                                                {{ now()->gt($lowongan->batasPendaftaran) || $isLocked ? 'disabled' : '' }}>
                                                            <label for="toggle-{{ $tahap->id }}"
                                                                class="tahap-toggle-label"></label>
                                                        </div>

                                                        @php
                                                            $dipakai = $tahap->progressTahapanRekrutmen->count() > 0;
                                                            $pendaftaranTutup = now()->gt($lowongan->batasPendaftaran);
                                                        @endphp

                                                        <button type="button" class="btnedit btn btn-secondary btn-sm"
                                                            data-id-tahapan="{{ $tahap->id }}"
                                                            data-name="{{ $tahap->name }}"
                                                            data-urutan="{{ $tahap->urutan }}"
                                                            data-tipe="{{ $tahap->tipe_tahap }}"
                                                            data-dipakai="{{ $dipakai ? 1 : 0 }}"
                                                            {{ $pendaftaranTutup ? 'disabled' : '' }}
                                                            style="width:45px;height:45px;border-radius:12px;font-size:18px;"
                                                            data-bs-toggle="modal" data-bs-target="#modaledittahap">
                                                            <i class="material-symbols-rounded text-sm">edit</i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ini yang kanan --}}
                            <div class="col-md-5 mb-4">
                                <div class="preview-panel p-4 shadow-lg border-radius-xl h-100"
                                    style="background:#1f2933; color:#fff;">
                                    <h6 class="mb-4 d-flex align-items-center gap-2 text-white">
                                        <span class="material-symbols-rounded text-info"
                                            style="font-size: 1.2rem;">visibility</span>
                                        Preview Workflow
                                    </h6>
                                    <div id="previewList" class="d-flex flex-column gap-3"
                                        data-id-lowongan = "{{ $lowongan->id }}">
                                        @foreach ($tahapan as $tahap)
                                            @if ($tahap->status == 1)
                                                <div class="p-3 rounded d-flex align-items-center gap-2 preview-item "
                                                    data-id = "{{ $tahap->id }}" style="background:#374151;">
                                                    <span
                                                        class="badge rounded-circle bg-dark p-3 d-flex justify-content-center align-items-center previewurutan"
                                                        style="width: 36px; height: 36px; font-size: 0.9rem; ">
                                                        {{ $tahap->urutan }}
                                                    </span>
                                                    <strong style="font-size: 0.95rem;" class="previewname">
                                                        {{ $tahap->name }}
                                                    </strong>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    <div class="modal fade" id="modaledittahap" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formeditPenilaian" method="POST">
                    @csrf
                    <div>
                        <div
                            class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                            <h5 class="modal-title text-white">Edit Tim Penilai</h5>
                            <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="idTahapan" id="idTahapan">
                            <div class="form-group mb-2">
                                <label for="nameTahapan" class="form-label fw-bold text-secondary">Nama Tahapan</label>
                                <div class="custom-tooltip" data-title="Masukkan nama field, wajib diisi">
                                    <i class="material-symbols-rounded text-secondary ms-1"
                                        style="font-size: 1rem;">info</i>
                                </div>
                                <input type="text" class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    name="name" id="edit_namaUrutan" placeholder= "Masukkan Tahapan Rekrutmen"
                                    value="{{ old('name') }}">
                                <div class="text-danger" id="errorName"></div>
                                {{-- @error('name')
                                    <div class="text-danger" id="errorName">{{ $message }}</div>
                                @enderror --}}
                            </div>

                            <div class="form-group mb-2">
                                <label for="urutanTahapan" class="form-label fw-bold text-secondary">Urutan
                                    Tahapan</label>
                                <div class="custom-tooltip"
                                    data-title="Urutan ini akan menentukan proses tahapan rekrutmen yang akan berjalan, wajib diisi">
                                    <i class="material-symbols-rounded text-secondary ms-1"
                                        style="font-size: 1rem;">info</i>
                                </div>
                                <input type="number" class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    name="urutan" id="edit_urutan" placeholder= "Masukkan Urutan Rekrutmen"
                                    value="{{ old('urutan') }}">

                                <div class="text-danger" id="errorUrutan"></div>
                                {{-- @error('urutan')
                                    <div class="text-danger" id="errorUrutan">{{ $message }}</div>
                                @enderror --}}
                            </div>
                            <div class = "form-group mb-2">
                                <label for="edit_tipe" class="form-label fw-bold text-secondary">
                                    Tipe Tahapan
                                </label>
                                <div class="custom-tooltip"
                                    data-title="Tahapan yang menentukan jenis proses tahapannya, wajib diisi">
                                    <i class="material-symbols-rounded text-secondary ms-1"
                                        style="font-size: 1rem;">info</i>
                                </div>
                                <select name="tipe_tahap" id="edit_tipe"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2">
                                    <option value="Seleksi">Seleksi</option>
                                    <option value="Wawancara">Wawancara</option>
                                    <option value="Final">Final</option>
                                </select>
                                <div class="text-danger" id="errorTipe"></div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaladdtahapan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('tahapan.tambah') }}" method="POST">
                    @csrf
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Tambah Tahapan</h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idLowongan" id="idLowongan">
                        <div class="form-group mb-1">
                            <label for="name" class="form-label fw-bold text-secondary">Nama</label>
                            <div class="custom-tooltip" data-title="Masukkan nama field, wajib diisi">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <input type="text" class="form-control shadow-sm border rounded-3 px-3 py-2"
                                name="name" id="namaUrutan" placeholder="Masukkan Nama urutan"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger" id="errorName">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="tipe_tahap" class="form-label fw-bold text-secondary">Tipe Tahapan</label>
                            <div class="custom-tooltip"
                                data-title="Tahapan yang menentukan jenis proses tahapannya, wajib diisi">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <select name="tipe_tahap" class="form-select shadow-sm border rounded-3 px-3 py-2">
                                <option value="" disabled selected>Pilih Tipe</option>
                                <option value="Seleksi" {{ old('tipe_tahap') == 'Seleksi' ? 'selected' : '' }}>Seleksi
                                </option>
                                <option value="Wawancara" {{ old('tipe_tahap') == 'Wawancara' ? 'selected' : '' }}>
                                    Wawancara</option>
                                <option value="Final" {{ old('tipe_tahap') == 'Final' ? 'selected' : '' }}>Final</option>
                            </select>
                            @error('tipe_tahap')
                                <div class="text-danger" id="errorTipe">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function refreshTahapan() {
            let idLowongan = $('#previewList').data('id-lowongan');
            $.get(`/tahapan/${idLowongan}/preview`, function(data) {

                let htmlkanan = '';
                data.forEach(function(tahapan) {
                    htmlkanan += `<div class="p-3 rounded d-flex align-items-center gap-2 preview-item "
                            data-id = "${tahapan.id}"
                                style="background:#374151;">
                                        <span
                                            class="badge rounded-circle bg-dark p-3 d-flex justify-content-center align-items-center previewurutan"
                                            style="width: 36px; height: 36px; font-size: 0.9rem; ">
                                                ${tahapan.urutan}
                                        </span>
                                        <strong style="font-size: 0.95rem;" class="previewname">
                                                ${tahapan.name}
                                         </strong>
                         </div>
                `;
                });
                $('#previewList').html(htmlkanan);
            });

            $.get(`/tahapan/${idLowongan}/previewkiri`, function(data) {
                let htmlkiri = '';

                data.forEach(function(tahapan) {
                    //ini supaya dia muncul kalau statusnya 1 aja
                    let isActive = tahapan.status === 1;
                    let bgColor = isActive ? '#f7f6f6ee' : 'lightgray';
                    let btnEdit = isActive ?
                        `<button type="button" class="btnedit btn btn-secondary btn-sm"
                                            data-id-tahapan="${tahapan.id}"
                                            data-name="${tahapan.name}"
                                            data-urutan ="${tahapan.urutan}"
                                            data-tipe = "${tahapan.tipe_tahap}"
                                            data-dipakai="${tahapan.dipakai}"
                                            style="width:45px;height:45px;border-radius:12px;font-size:18px;"
                                            data-bs-toggle="modal" data-bs-target="#modaledittahap">
                                            <i class="material-symbols-rounded text-sm">edit</i>
                </button>` : '';

                    htmlkiri += ` <div class="tahapCard d-flex justify-content-between align-items-center w-100 p-3 rounded"
                                    style="background:${bgColor}; border-left:5px; box-shadow:0 4px 12px rgba(0,0,0,0.08); border-radius:12px; border:1px solid rgb(118, 113, 113);">
                                        <div class="d-flex align-items-center gap-3">
                                            <span
                                                class="tahapurutan badge rounded-circle bg-dark p-3 d-flex justify-content-center align-items-center"
                                                style="width: 36px; height: 36px; font-size: 0.9rem; ">
                                                ${tahapan.urutan}
                                            </span>
                                        <div class="d-flex flex-column">
                                            <strong style="font-size: 0.95rem;" class="tahapname">
                                                    ${tahapan.name }
                                            </strong>
                                            <small class="text-info fw-semibold">
                                                        Tipe: ${tahapan.tipe_tahap }
                                            </small>
                                            <small class="text-secondary d-block">
                                                ${tahapan.status == 1 ? 'Aktif' : 'Non-Aktif'}
                                            </small>
                                        </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="tahap-toggle-switch">
                                                <input type="checkbox" id="toggle-${tahapan.id}"
                                                    class="tahap-toggle-input" data-id="${tahapan.id}"
                                                        ${tahapan.status == 1 ? 'checked' : '' }>
                                                    <label for="toggle-${tahapan.id}"
                                                        class="tahap-toggle-label"></label>
                                            </div>

                                            ${btnEdit}
                                        </div>
                            </div>`;
                });
                $('#listTahapan').html(htmlkiri);
            });
        }

        $(document).on('change', '.tahap-toggle-input', function() {
            let toggle = $(this);
            let id = toggle.data('id');
            let isChecked = toggle.is(':checked');

            let previouschecked = !isChecked;

            const actionText = isChecked ? 'mengaktifkan' : 'menonaktifkan';

            Swal.fire({
                title: `Apakah kamu yakin ingin ${actionText} tahap ini?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                //ini buat kalau gagal jadi togglenya stay atau balik ke keadaan sebelumnya
                if (!result.isConfirmed) {
                    toggle.prop('checked', previouschecked);
                    return;
                }

                //jadi biar kalau di onoff dia bisa
                //ini buat ambil data
                let card = toggle.closest('.tahapCard');
                let urutan = card.find('.tahapurutan').text().trim();
                let name = card.find('.tahapname').text().trim();

                if (result.isConfirmed) {
                    toggle.prop('checked', isChecked);

                    $.ajax({
                        url: `/tahapan/${id}/toggle`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: isChecked ? 1 : 0
                        },
                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            refreshTahapan();
                        },
                        error: function() {
                            toggle.prop('checked', previouschecked);

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat mengubah status field.'
                            });
                        }
                    });
                }

            });
        });


        $(document).on('click', '.btnedit', function() {

            let id = $(this).data('id-tahapan');
            let name = $(this).data('name');
            let urutan = $(this).data('urutan');
            let tipe = $(this).data('tipe')
            let dipakai = $(this).data('dipakai');

            $('#idTahapan').val(id);
            $('#edit_namaUrutan').val(name);
            $('#edit_urutan').val(urutan);
            $('#edit_tipe').val(tipe);
            $('#errorName').text('');
            $('#errorUrutan').text('');
            $('#errorTipe').text('');

            if (dipakai == 1) {
                $('#edit_urutan').prop('disabled', true);
            } else {
                $('#edit_urutan').prop('disabled', false);
            }
            // $('#formeditPenilaian').attr('action', '/tahapan/' + id + '/update');
        });

        //ini jadinya kita pisah supaya dia bisa buat priviewnya update
        //kita harus pakai ini karena setelah aku coba supaya bisa upadte previewnya
        $('#formeditPenilaian').submit(function(e) {
            e.preventDefault();
            //ini jadinya kalau submit kita ambil data yang udah diisi
            let id = $('#idTahapan').val();
            let name = $('#edit_namaUrutan').val();
            let urutan = $('#edit_urutan').val();
            let tipe_tahap = $('#edit_tipe').val();

            $.post(`/tahapan/${id}/update`, {
                _token: '{{ csrf_token() }}',
                name,
                urutan,
                tipe_tahap
            }, function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#modaledittahap').modal('hide');
                refreshTahapan();
                //kenapa errornya gini karena kita pakai prevent default jadi gak ada reload langsung 
            }).fail(function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON?.errors || {};
                    $('#errorName').text(errors.name ? errors.name[0] : '');
                    $('#errorUrutan').text(errors.urutan ? errors.urutan[0] : '');
                    $('#errorTipe').text(errors.tipe_tahap ? errors.tipe_tahap[0] : '');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Terjadi kesalahan sistem'
                    });
                }
            });

        });

        //ini mengirim id si lowongan
        $(document).on('click', '[data-bs-target="#modaladdtahapan"]', function() {
            $('#idLowongan').val($(this).data('id-lowongan'));
        });

        $('#modaledittahap , #modaladdtahapan').on('hidden.bs.modal', function() {
            //hapus pesan error
            $(this).find('.text-danger').text('');
            $(this).find('input:not([type=hidden])').val('');
        });

        @if ($errors->any())
            $(document).ready(function() {
                @if (old('idTahapan'))
                    $('#modaledittahap').modal('show');
                @endif

                @if (old('idLowongan'))
                    $('#modaladdtahapan').modal('show');
                @endif
            });
        @endif
    </script>
@endpush
