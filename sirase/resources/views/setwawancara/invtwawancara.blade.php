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
                {{-- <form method="POST" id="formwawancara" action="{{ route('kandidat.addWawancara') }}"> --}}
                <form method="POST" id="formwawancara" action="/simpanWawancara">
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
                            <label for="timPenilai"
                                class="form-label fw-bold text-secondary d-flex align-items-center mt-1">Penilai
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Penilai wajib diisi boleh memilih lebih dari 1"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                            </label>
                            <div class="d-flex flex-wrap gap-3">

                                @foreach ($penilai as $p)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="tim_penilai[]"
                                            value="{{ $p->idStaffUnit }}">

                                        <label class="form-check-label">
                                            {{ $p->namaPenilai }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggalWawancara"
                                class="form-label fw-bold text-secondary d-flex align-items-center mt-1">Tanggal
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
                            <label for="Waktu_Mulai"
                                class="form-label fw-bold text-secondary d-flex align-items-center mt-1">
                                Waktu Mulai
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip"
                                    title="Waktu Mulai wajib diisi" style="font-size: 1rem; cursor: help; line-height:0.5;">
                                    info
                                </i>
                            </label>
                            <input type="time" name="waktu_mulai" class="form-control border rounded-3 px-3 py-2">
                        </div>
                        <div class="form-group">
                            <label for="Waktu_Selesai"
                                class="form-label fw-bold text-secondary d-flex align-items-center mt-1">
                                Waktu Selesai
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip"
                                    title="Waktu Selesai wajib diisi" style="font-size: 1rem; cursor: help; line-height:0;">
                                    info
                                </i>
                            </label>
                            <input type="time" name="waktu_selesai" class="form-control border rounded-3 px-3 py-2">
                        </div>
                        <div class="form-group">
                            <label for="lokasi"
                                class="form-label fw-bold text-secondary d-flex align-items-center mt-1">Lokasi Interview
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip"
                                    title="Lokasi wajib diisi" style="font-size: 1rem; cursor: help; line-height:1;">
                                    info
                                </i>
                            </label>
                            <input type="text" class="form-control border rounded-3 px-3 py-2" name="lokasi">
                        </div>
                        <div class="form-group">
                            <label for="link_wawancara"
                                class="form-label fw-bold text-secondary d-flex align-items-center mt-1">Link Wawancara
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
                            <label for="keterangan"
                                class="form-label fw-bold text-secondary d-flex align-items-center">Keterangan
                                <i class="material-symbols-rounded text-secondary ms-1" data-bs-toggle="tooltip"
                                    title="Keterangan wajib diisi dan max karakternya 255"
                                    style="font-size: 1rem; cursor: help; line-height:1;">
                                    info
                                </i>
                            </label>
                            <textarea id="keterangan" name="keterangan" class="form-control border rounded-3 px-3 py-2" rows="2">
                            </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button> --}}
                        <button type="submit" class="btn btn-success" id="btnSubmit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetailJadwal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                    <h5 class="modal-title text-white">Detail Wawancara </h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Mahasiswa: </strong><span id="detailNama"></span></p>
                    <p><strong>Lowongan:</strong> <span id="detailLowongan"></span></p>
                    <p><strong>Penilai:</strong> <span id="detailPenilai"></span></p>
                    <p><strong>Waktu Wawancara:</strong> <span id="detailJam"></span></p>
                    <p><strong>Lokasi:</strong> <span id="detailLokasi"></span></p>
                    <p><strong>Link:</strong> <a href="#" id="detailLink" target="_blank">Buka Link</a></p>
                    <p><strong>Keterangan:</strong> <span id="detailKeterangan"></span></p>
                    <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        $(document).ready(function() {
            let calendarEl = document.getElementById('calendar');
            let dataWawancara = [];

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                height: '75vh',
                selectable: true,

                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },

                displayEventTime: true,
                displayEventEnd: true,

                dateClick: function(info) {
                    $('#modalwawancara').modal('show');
                    $('#tanggal_wawancara').val(info.dateStr);
                },

                eventClick: function(info) {
                    let e = info.event.extendedProps;

                    $('#detailNama').text(info.event.title);
                    $('#detailLowongan').text(e.namaLowongan);
                    $('#detailJam').text(e.waktuMulai + ' - ' + e.waktuSelesai);
                    $('#detailPenilai').text(e.penilaiStr);
                    $('#detailLokasi').text(e.lokasi || '-');
                    $('#detailLink').attr('href', e.link || '#');
                    $('#detailKeterangan').text(e.keterangan || '-');
                    $('#detailStatus').text(e.status);

                    $('#modalDetailJadwal').modal('show');
                }
            });

            let tanggalvent = [];

            $.get("{{ route('jadwal.alljadwal') }}", function(data) {
                dataWawancara = data;
                data.forEach(function(item) {
                    let warna = '#6c757d';
                    if (item.status === 'terjadwal') warna = '#0d6efd';
                    else if (item.status === 'selesai') warna = '#198754';
                    else if (item.status === 'batal') warna = '#dc3545';

                    calendar.addEvent({
                        id: item.id,
                        title: item.namaMahasiswa,
                        start: item.tanggalWawancara + 'T' + item.waktuMulai,
                        end: item.tanggalWawancara + 'T' + item.waktuSelesai,
                        backgroundColor: warna,
                        borderColor: warna,
                        extendedProps: {
                            namaLowongan: item.namaLowongan,
                            penilaiStr: item.penilaiStr,
                            lokasi: item.lokasi,
                            link: item.link,
                            keterangan: item.keterangan,
                            status: item.status,
                            waktuMulai: item.waktuMulai,
                            waktuSelesai: item.waktuSelesai
                        }
                    });
                });
                 
            });
            calendar.render();
        });
    </script>
@endpush
