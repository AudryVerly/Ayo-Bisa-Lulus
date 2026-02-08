@extends('layouts.app')
@section('breadcrumb', 'Kelola Formulir')

@section('content')
    <div class="container-fluid py-4">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                <div
                    class ="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                    <h6 class="text-white text-capitalize m-0">{{ $lowongan->judulLowongan }}-Form Builder</h6>
                </div>
            </div>
            <div class="card-body bg-light" style="border-radius: 0 0 12px 12px;">
                @foreach ($field as $f)
                    <div class="field-card p-3 mb-3 shadow-sm border rounded d-flex align-items-center gap-3 justify-content-between {{ $f->status == 0 ? 'field-disabled text-muted' : 'bg-white' }}">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            <div class="bg-dark text-white d-flex justify-content-center align-items-center"
                                style="width:45px;height:45px;border-radius:12px;font-size:18px;">

                                @if ($f->tipeField == 'text')
                                    <i class="material-symbols-rounded text-sm">text_fields</i>
                                @elseif ($f->tipeField == 'number')
                                    <i class="material-symbols-rounded text-sm">format_list_numbered_rtl</i>
                                @elseif ($f->tipeField == 'date')
                                    <i class="material-symbols-rounded text-sm">date_range</i>
                                @elseif ($f->tipeField == 'textarea')
                                    <i class="material-symbols-rounded text-sm">text_fields</i>
                                @elseif ($f->tipeField == 'select')
                                    <i class="material-symbols-rounded text-sm">expand_circle_down</i>
                                @elseif ($f->tipeField == 'radio')
                                    <i class="material-symbols-rounded text-sm">radio_button_checked</i>
                                @elseif ($f->tipeField == 'checkbox')
                                    <i class="material-symbols-rounded text-sm">check_box</i>
                                @elseif ($f->tipeField == 'file')
                                    <i class="material-symbols-rounded text-sm">attach_file</i>
                                @elseif ($f->tipeField == 'phone')
                                    <i class="material-symbols-rounded text-sm">text_fields</i>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 d-flex align-items-center gap-2">{{ $f->namaField }}
                                        @if ($f->required == 1)
                                            <span class="text-danger fw-bold" style="font-size: 0.75rem; line-height: 1;">
                                                REQUIRED
                                            </span>
                                        @else
                                            <span class="text-primary fw-bold" style="font-size: 0.75rem; line-height: 1;">
                                                OPTIONAL
                                            </span>
                                        @endif
                                    </h6>
                                    <small class="text-secondary d-block">
                                        {{ strtoupper($f->tipeField) }}
                                    </small>

                                    @if (in_array($f->tipeField, ['select', 'radio', 'checkbox']))
                                        <small class="text-info">Opsi: {{ $f->opsi_field }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="text-end d-flex align-items-center gap-2">
                            <button type ="button" class="btnedit btn btn-secondary btn-sm d-flex justify-content-center align-items-center {{ $f->status == 1 ? '' : 'd-none' }}"
                                style="width:45px;height:45px;border-radius:12px;font-size:18px;"
                                data-id-field="{{ $f->id }}" data-nama="{{ $f->namaField }}"
                                data-tipe="{{ $f->tipeField }}" data-opsi="{{ $f->opsi_field }}"
                                data-required="{{ $f->required }}" data-bs-toggle="modal"
                                data-bs-target="#modaleditfield">

                                <i class="material-symbols-rounded text-sm">edit</i>
                            </button>

                            <button
                                class="btn btn-secondary btn-sm btntoggle d-flex justify-content-center align-items-center"
                                style="width:45px;height:45px;border-radius:12px;font-size:18px;"
                                data-id="{{ $f->id }}" data-status="{{ $f->status }}">

                                <i class= "material-symbols-rounded text-sm align-middle flex-grow-2">
                                    {{ $f->status == 1 ? 'toggle_on' : 'toggle_off' }}</i>
                            </button>
                        </div>
                    </div>
                @endforeach
                <div>
                    <button class=" btn btn-outline-secondary btn-lg w-100 text-center py-3" data-bs-toggle="modal"
                        data-bs-target="#modaladdfield" data-id-lowongan={{ $lowongan->id }}>
                        <i class="material-symbols-rounded text-dark">add_2</i>
                    </button>
                </div>
                @push('modals')
                    <div class="modal fade" id="modaladdfield" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('formulir.add') }}" method="POST">
                                    @csrf
                                    <div
                                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                                        <h5 class="modal-title text-white">Tambah Title</h5>
                                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" name="idLowongan" id="idLowongan">

                                        <div class="form-group mb-2">
                                            <label for="namaField" class="form-label fw-bold text-secondary"> Nama
                                                Field</label>
                                            <input type="text" class="form-control shadow-sm border rounded-3 px-3 py-2"
                                                name="namaField" id="namaField" placeholder="Masukkan Nama Field"
                                                value="{{ old('namaField') }}">
                                            @error('namaField')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="tipeField" class="form-label fw-bold text-secondary"> Tipe
                                                Field</label>
                                            <select name="tipeField" id="tipeField"
                                                class="form-select shadow-sm border rounded-3 px-3 py-2">
                                                <option value="" disabled {{ old('tipeField') ? '' : 'selected' }}>
                                                    Tipe Field</option>
                                                <option value="text" {{ old('tipeField') == 'text' ? 'selected' : '' }}>
                                                    Text</option>
                                                <option value="number" {{ old('tipeField') == 'number' ? 'selected' : '' }}>
                                                    Number</option>
                                                <option value="date" {{ old('tipeField') == 'date' ? 'selected' : '' }}>
                                                    Date</option>
                                                <option value="textarea"
                                                    {{ old('tipeField') == 'textarea' ? 'selected' : '' }}>TextArea
                                                </option>
                                                <option value="select" {{ old('tipeField') == 'select' ? 'selected' : '' }}>
                                                    Select(dropdown)
                                                </option>
                                                <option value="radio" {{ old('tipeField') == 'radio' ? 'selected' : '' }}>
                                                    Radiobutton</option>
                                                <option value="checkbox"
                                                    {{ old('tipeField') == 'checkbox' ? 'selected' : '' }}>Checkbox
                                                </option>
                                                <option value="file" {{ old('tipeField') == 'file' ? 'selected' : '' }}>
                                                    File</option>
                                                <option value="phone" {{ old('tipeField') == 'phone' ? 'selected' : '' }}>
                                                    Phone</option>
                                            </select>
                                            @error('tipeField')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-2" id="opsiWrap" style="display:none">
                                            <label for="opsiField" class="form-label fw-bold text-secondary"> Opsi
                                                Field</label>
                                            <input type="text" name="opsi_field" id="opsi_field"
                                                class="form-control shadow-sm border rounded-3 px-3 py-2" name="opsi_field"
                                                id="opsi_field" placeholder="contoh:opsi1, opsi2, opsi3"
                                                value="{{ old('opsi_field') }}">
                                            @error('opsi_field')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="hidden" name="required" value="0">

                                            <input class="form-check-input" type="checkbox" name="required"
                                                id="add_required" value="1" {{ old('required') == 1 ? 'checked' : '' }}>

                                            <label class="form-check-label fw-bold ms-2" for="add_required">
                                                Tandai jika field ini <span class="text-danger">WAJIB DIISI/OPTIONAL</span>
                                            </label>

                                            @error('required')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modaleditfield" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form id="formEditField" method="POST">
                                    @csrf
                                    <div>
                                        <div
                                            class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                                            <h5 class="modal-title text-white">Edit Field</h5>
                                            <button type="button" class="btn-close btn-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <input type= "hidden" name="idField" id="idField">

                                            <div class="form-group mb-2">
                                                <label for="namaField" class="form-label fw-bold text-secondary"> Nama
                                                    Field</label>
                                                <input type="text"
                                                    class="form-control shadow-sm border rounded-3 px-3 py-2" name="namaField"
                                                    id="edit_namaField" placeholder="Masukkan Nama Field"
                                                    value="{{ old('namaField') }}">

                                                @error('namaField')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group mb-2">
                                                <label for="tipeField" class="form-label fw-bold text-secondary"> Tipe
                                                    Field</label>
                                                <select name="tipeField" id="edit_tipeField"
                                                    class="form-select shadow-sm border rounded-3 px-3 py-2">
                                                    <option value="" disabled {{ old('tipeField') ? '' : 'selected' }}>
                                                        Tipe Field</option>
                                                    <option value="text" {{ old('tipeField') == 'text' ? 'selected' : '' }}>
                                                        Text</option>
                                                    <option value="number"
                                                        {{ old('tipeField') == 'number' ? 'selected' : '' }}>
                                                        Number</option>
                                                    <option value="date" {{ old('tipeField') == 'date' ? 'selected' : '' }}>
                                                        Date</option>
                                                    <option value="textarea"
                                                        {{ old('tipeField') == 'textarea' ? 'selected' : '' }}>Textarea
                                                    </option>
                                                    <option value="select"
                                                        {{ old('tipeField') == 'select' ? 'selected' : '' }}>
                                                        Select(dropdown)
                                                    </option>
                                                    <option value="radio"
                                                        {{ old('tipeField') == 'radio' ? 'selected' : '' }}>
                                                        Radiobutton</option>
                                                    <option value="checkbox"
                                                        {{ old('tipeField') == 'checkbox' ? 'selected' : '' }}>Checkbox
                                                    </option>
                                                    <option value="file" {{ old('tipeField') == 'file' ? 'selected' : '' }}>
                                                        File</option>
                                                    <option value="phone"
                                                        {{ old('tipeField') == 'phone' ? 'selected' : '' }}>
                                                        Phone</option>
                                                </select>
                                                @error('tipeField')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group mb-2" id="edit_opsiWrap" style="display:none">
                                                <label for="opsiField" class="form-label fw-bold text-secondary"> Opsi
                                                    Field</label>
                                                <input type="text" name="opsi_field" id="edit_opsi_field"
                                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                                    placeholder="contoh:opsi1, opsi2, opsi3" value="{{ old('opsi_field') }}">
                                                @error('opsi_field')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-check mb-2">
                                                <input type="hidden" name="required" value="0">

                                                <input class="form-check-input" type="checkbox" name="required"
                                                    id="edit_required" value="1"
                                                    {{ old('required') == 1 ? 'checked' : '' }}>

                                                <label class="form-check-label fw-bold ms-2" for="edit_required">
                                                    Tandai jika field ini <span class="text-danger">WAJIB DIISI/OPTIONAL</span>
                                                </label>

                                                @error('required')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endpush
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '[data-bs-target="#modaladdfield"]', function() {
            $('#idLowongan').val($(this).data('id-lowongan'));
        });

        $('#tipeField').on('change', function() {
            let tipe = $(this).val();

            if (['select', 'radio', 'checkbox'].includes(tipe)) {
                $('#opsiWrap').slideDown();
            } else {
                $('#opsiWrap').slideUp();
                $('#opsi_field').val('');
            }
        })

        $(document).on('click', '.btnedit', function() {
            let id = $(this).data('idField');
            let nama = $(this).data('nama');
            let tipe = $(this).data('tipe');
            let opsi = $(this).data('opsi');
            let required = $(this).data('required');

            console.log('Edit ID:', id);
            console.log('All data:', $(this).data());

            $('#idField').val(id);
            $('#edit_namaField').val(nama);
            $('#edit_tipeField').val(tipe);
            $('#edit_opsi_field').val(opsi);
            $('#edit_required').prop('checked', required == '1');

            if (['select', 'radio', 'checkbox'].includes(tipe)) {
                $('#edit_opsiWrap').show();
            } else {
                $('#edit_opsiWrap').hide();
            }

            $('#formEditField').attr('action', '/formulir/' + id + '/update');

        });

        //ini kalau misalnya ada yang awalnya dari select dan lainnya ke text bakal ke hapus isi o
        $('#edit_tipeField').on('change', function() {
            let tipe = $(this).val();
            if (['select', 'radio', 'checkbox'].includes(tipe)) {
                $('#edit_opsiWrap').slideDown();
            } else {
                $('#edit_opsiWrap').slideUp();
                $('#edit_opsi_field').val('');
            }
        });

        $(document).on('click', '.btntoggle', function() {

            let btn = $(this);
            let id = btn.data('id');
            let status = btn.data('status');

            let activate = status == 0;

            // cari kartu terdekat
            let card = btn.closest('.field-card');

            // cari tombol edit
            let editBtn = card.find('.btnedit');

            let url = activate ?
                `/formulir/${id}/active` :
                `/formulir/${id}/nonactive`;

            const actionText = activate ? 'mengaktifkan' : 'menonaktifkan';

            Swal.fire({
                title: `Apakah kamu yakin ingin ${actionText} field ini?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {

                            let newStatus = status == 1 ? 0 : 1;
                            
                            status = newStatus;
                            btn.data('status', newStatus);

                            // ubah icon
                            btn.find('i').text(
                                newStatus == 1 ? 'toggle_on' : 'toggle_off'
                            );

                            // atur tampilan card + tombol edit
                            if (newStatus == 0) {
                                card.removeClass('bg-white');
                                card.addClass('field-disabled text-muted');
                                editBtn.addClass('d-none');
                            } else {
                                card.removeClass('field-disabled text-muted');
                                card.addClass('bg-white');
                                editBtn.removeClass('d-none');
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },

                        error: function() {
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
    </script>
@endpush
