@extends('layouts.app')
@section('breadcrumb', 'Jadwal Wawancara Mahasiswa')
@section('content')
    <div class="container-fluid py-3">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold">Jadwal Wawancara Lowongan Student Employee </h6>
            </div>

            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    <div class="modal fade" id="modalDetailJadwal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                    <h5 class="modal-title text-white">Detail Wawancara </h5>
                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Mahasiswa: </strong><span id="m_mahasiswa"></span></p>
                    <p><strong>Lowongan:</strong> <span id="m_lowongan"></span></p>
                    <p><strong>Penilai:</strong> <span id="m_penilai"></span></p>
                    <p><strong>Waktu Wawancara:</strong> <span id="m_jam"></span></p>
                    <p><strong>Lokasi:</strong> <span id="m_lokasi"></span></p>
                    <p><strong>Link:</strong>
                        <a href="#" id="m_link" class="d-none" target="_blank">Buka Link</a>
                        <span id="m_link_placeholder">-</span>
                    </p>
                    <p><strong>Status:</strong> <span id="m_status"></span></p>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        $(document).ready(function() {
            let dataWawancara = @json($jadwal);

            let calendar = new FullCalendar.Calendar($('#calendar')[0], {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                height: '75vh',

                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },

                displayEventTime: true,
                displayEventEnd: true,
                
                events: dataWawancara.map(item => ({
                    id: item.id,
                    title: item.namaMahasiswa,
                    start: item.tanggalWawancara + 'T' + item.waktuMulai,
                    end: item.tanggalWawancara + 'T' + item.waktuSelesai,
                    backgroundColor: item.status === 'terjadwal' ? '#0d6efd' : '#6c757d',
                    borderColor: item.status === 'terjadwal' ? '#0d6efd' : '#6c757d',
                    extendedProps: item
                })),
                eventClick: function(info) {
                    let e = info.event.extendedProps;

                    $('#m_mahasiswa').text(e.namaMahasiswa);
                    $('#m_lowongan').text(e.namaLowongan);
                    $('#m_tanggal').text(e.tanggalWawancara);
                    $('#m_jam').text(e.waktuMulai + ' - ' + e.waktuSelesai);
                    $('#m_lokasi').text(e.lokasi || '-');
                    $('#m_penilai').text(e.penilaiStr || '-');
                    $('#m_status').text(e.status);

                    if (e.link && e.link.trim() !== '') {
                        $('#m_link').removeClass('d-none').attr('href', e.link);
                        $('#m_link_placeholder').addClass('d-none');
                    } else {
                        $('#m_link').addClass('d-none');
                        $('#m_link_placeholder').removeClass('d-none').text('-');
                    }

                    let modal = new bootstrap.Modal($('#modalDetailJadwal')[0]);
                    modal.show();
                }
            });

            calendar.render();

        });
    </script>
@endpush
