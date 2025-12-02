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
                    <div
                        class="p-3 mb-3 bg-white shadow-sm border rounded d-flex align-items-center gap-3 justify-content-between">
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
                                    <i class="material-symbols-rounded text-sm">text_select_area</i>
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
                            <form action="" method="GET">
                                @csrf
                                <button id="btnedit"
                                    class="btn btn-secondary btn-sm d-flex justify-content-center align-items-center"
                                    style="width:45px;height:45px;border-radius:12px;font-size:18px;"
                                    data-id={{ $f->id }} data-nama={{ $f->namaField }} data-tipe={{ $f->tipeField }}
                                    data-opsi={{ $f->opsi_field }} data-required={{ $f->required }}>

                                    <i class="material-symbols-rounded text-sm">edit</i>
                                </button>
                            </form>
                            @if ($f->status == 1)
                                <button id ="btnoff"
                                    class="btn btn-secondary btn-sm d-flex justify-content-center align-items-center"
                                    style="width:45px;height:45px;border-radius:12px;font-size:18px;"
                                    data-id={{ $f->id }}>
                                    <i class= "material-symbols-rounded text-sm align-middle flex-grow-2">
                                        toggle_off</i>
                                </button>
                            @else
                                <button id="btnon"
                                    class="btn btn-secondary btn-sm d-flex justify-content-center align-items-center"
                                    style="width:45px;height:45px;border-radius:12px;font-size:18px;"
                                    data-id={{ $f->id }}>
                                    <i class= "material-symbols-rounded text-sm align-middle">toggle_on</i>
                                </button>
                            @endif
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
                                                    {{ old('tipeField') == 'textarea' ? 'selected' : '' }}>Textarea
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
                @endpush
            </div>
        </div>
    </div>
@endsection
@push('scripts')
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
    </script>
@endpush
