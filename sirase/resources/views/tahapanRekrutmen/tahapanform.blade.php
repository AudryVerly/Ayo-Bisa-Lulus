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
                            <button class="btn bg-white text-dark border shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#modaladdtahapan" data-id-lowongan={{ $lowongan->id }}>
                                <i class="material-symbols-rounded text-sm align-middle text-success">add</i>
                                <span class="align-middle fw-bold">Tambah Unit</span>
                            </button>
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
                                        <div class="d-flex flex-column gap-3 rounded">
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
                                                                {{ $tahap->status == 1 ? 'checked' : '' }}>
                                                            <label for="toggle-{{ $tahap->id }}"
                                                                class="tahap-toggle-label"></label>
                                                        </div>

                                                        <button type="button"
                                                            class="btn btn-secondary btn-sm btnedittahapan"
                                                            data-id="{{ $tahap->id }}" data-name="{{ $tahap->name }}"
                                                            data-status="{{ $tahap->status }}"
                                                            style="width:45px;height:45px;border-radius:12px;font-size:18px;"
                                                            data-bs-target="#modaledittahap">
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
                                    <div id="previewList" class="d-flex flex-column gap-3">
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
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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

                            //kalau misalnya udah di checked tapi belum muncul nanti di munculin
                            if (isChecked) {
                                if ($('#previewList').find(`[data-id = "${id}"]`).length ===
                                    0) {
                                    $(`#previewList`).append(`
                                        <div class="p-3 rounded d-flex align-items-center gap-2 preview-item "
                                            data-id = "${id}"
                                                style="background:#374151;">
                                                <span
                                                    class="badge rounded-circle bg-dark p-3 d-flex justify-content-center align-items-center previewurutan"
                                                    style="width: 36px; height: 36px; font-size: 0.9rem; ">
                                                    ${urutan}
                                                </span>
                                                <strong style="font-size: 0.95rem;" class="previewname">
                                                    ${name}
                                                </strong>
                                        </div>
                                    `);
                                }
                            } else {
                                $('#previewList').find(`[data-id="${id}"]`).remove();
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
    </script>
@endpush
