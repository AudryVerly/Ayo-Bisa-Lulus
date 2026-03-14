@extends('layouts.app')
@section('breadcrumb', 'Kalendar Wawancara')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold">Jadwal Wawancara Kandidat</h6>
            </div>

            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    <div class="modal fade" id="modalwawancara" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="POST" id="formwawancara">
                    @csrf
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Tambah Jadwal Wawancara </h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idPendaftaran" value="{{ $pendaftaran->idPendaftaran }}">
                        <input type="hidden" name="idProgressTahapan" value="{{ $idProgressTahapan }}">
                        <div class="form-group mb-1">
                            <label for="namaMahasiswa" class="form-label fw-bold text-secondary">Nama Mahasiswa</label>
                            <input type="text" class="form-control border rounded-3 px-3 py-2"
                                style="background-color: #e0e0e0; color: #6e757b;" value="{{ $pendaftaran->namaMahasiswa }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="timPenilai" class="form-label fw-bold text-secondary d-flex align-items-center mt-1">Penilai
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Penilai wajib diisi boleh memilih lebih dari 1"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                            </label>
                            <div class="d-flex flex-wrap gap-3">

                                @foreach ($penilai as $p)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="tim_penilai[]"
                                            value="{{ $p->idTimPenilai }}">

                                        <label class="form-check-label">
                                            {{ $p->namaPenilai }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                            {{-- <select class="form-select shadow-sm border rounded-3 px-3 py-2" id="tim_penilai[]" required>
                                <option value="" disabled selected>Pilih User</option>
                                @foreach ($penilai as $p)
                                    <option value="{{ $p->idTimPenilai }}">
                                        {{ $p->namaPenilai }}
                                    </option>
                                @endforeach
                            </select> --}}
                        </div>
                        <div class="form-group">
                            <label for="tanggalWawancara" class="form-label fw-bold text-secondary d-flex align-items-center mt-1">Tanggal
                                Wawancara
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip"
                                    title="Tanggal Wawancara wajib diisi sesuai dengan tanggal yang benar"
                                    style="font-size: 1rem; cursor: help; line-height:0.5;">
                                    info
                                </i>
                            </label>
                            <input type="date" name="tanggal_wawancara" id="tanggal_wawancara"
                                class="form-control border rounded-3 px-3 py-2">
                        </div>
                        <div class="form-group">
                            <label for="Waktu_Mulai" class="form-label fw-bold text-secondary d-flex align-items-center mt-1">
                                Waktu Mulai
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip"
                                    title="Waktu Mulai wajib diisi" style="font-size: 1rem; cursor: help; line-height:0.5;">
                                    info
                                </i>
                            </label>
                            <input type="time" nama="waktu_mulai"
                                class="form-control border rounded-3 px-3 py-2">
                        </div>
                        <div class="form-group">
                            <label for="Waktu_Selesai" class="form-label fw-bold text-secondary d-flex align-items-center mt-1">
                                Waktu Selesai
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip"
                                    title="Waktu Selesai wajib diisi"
                                    style="font-size: 1rem; cursor: help; line-height:0;">
                                    info
                                </i>
                            </label>
                            <input type="time" nama="waktu_selesai"
                                class="form-control border rounded-3 px-3 py-2">
                        </div>
                        <div class="form-group">
                            <label for="lokasi" class="form-label fw-bold text-secondary d-flex align-items-center mt-1">Lokasi Interview
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip"
                                    title="Lokasi wajib diisi" style="font-size: 1rem; cursor: help; line-height:1;">
                                    info
                                </i>
                            </label>
                            <input type="text" class="form-control border rounded-3 px-3 py-2" name="lokasi">
                        </div>
                        <div class="form-group">
                            <label for="link_wawancara" class="form-label fw-bold text-secondary d-flex align-items-center mt-1">Link Wawancara
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip"
                                    title="Link Wawancara wajib diisi"
                                    style="font-size: 1rem; cursor: help; line-height:1;">
                                    info
                                </i>
                            </label>
                            <div class="input-group border-0 rounded-3 overflow-hidden">
                                <input type="text" class="form-control border py-2 px-3" id="link_wawancara"
                                    name="link_wawancara">
                                <span
                                    class="input-group-text bg-success text-white border-0 px-3 d-flex align-items-center justify-content-center"
                                    style="cursor: pointer; line-height: 1; min-height: 100%;"
                                    onclick="window.open('https://meet.google.com/new', '_blank')">
                                    Buat Meet
                                </span>
                            </div>
                        </div>
                        <div>
                            <label for="keterangan" class="form-label fw-bold text-secondary d-flex align-items-center">Keterangan
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip"
                                    title="Keterangan wajib diisi dan max karakternya 255" style="font-size: 1rem; cursor: help; line-height:1;">
                                    info
                                </i>
                            </label>
                            <textarea id="keterangan" name="keterangan" class="form-control border rounded-3 px-3 py-2"
                                rows="2">
                            </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button> --}}
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        $(document).ready(function() {
            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                intialView: 'dayGridMonth',

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                height: '75vh',

                selectable: true,

                dateClick: function(info) {
                    $('#modalwawancara').modal('show');
                    $('#tanggal_wawancara').val(info.dateStr);
                }
            });

            calendar.render();
        });
    </script>
@endpush
