@extends('layouts.app')
@section('breadcrumb', 'Jadwal Wawancara Kandidat')
@section('content')
    <div class="container-fluid py-3">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold">Jadwal Wawancara Kandidat Lowongan Student Employee </h6>
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
                    <p><strong>Nama Mahasiswa: </strong><span id="detailmahasiswa"></span></p>
                    <p><strong>Lowongan:</strong> <span id="detaillowongan"></span></p>
                    <p><strong>Waktu Wawancara:</strong> <span id="detailjam"></span></p>
                    <p><strong>Lokasi:</strong> <span id="detaillokasi"></span></p>
                    <p><strong>Link:</strong>
                        <a href="#" id="detaillink" class="d-none" target="_blank">Buka Link</a>
                        <span id="detaillinkplaceholder">-</span>
                    </p>
                    <p><strong>Status:</strong> <span id="detailstatus"></span></p>
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

            let calendar = new FullCalendar.Calendar($('#calendar')[0] {
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

                events: dataWawancara.map(item => {
                    let warna = '#6c757d';
                    if (item.statusPenilai === 'terjadwal') warna = '#0d6efd';
                    else if (item.statusPenilai === 'selesai') warna = '#198754';
                    else if (item.statusPenilai === 'belum') warna ='#ffc107';
                    return {
                        id: item.id,
                        title: item.namaMahasiswa,
                        start: item.tanggalWawancara + 'T' + item.waktuMulai,
                        end: item.tanggalWawancara + 'T' + item.waktuSelesai,
                        backgroundColor: warna,
                        borderColor: warna,
                        extendedProps: item
                    };
                }),

                eventClick: function(info) {
                    let e = info.event.extendedProps;

                    $('#detailmahasiswa').text(e.namaMahasiswa);
                    $('#detaillowongan').text(e.namaLowongan);
                    $('#detailtanggal').text(e.tanggalWawancara);
                    $('#detailjam').text(e.waktuMulai + ' - ' + e.waktuSelesai);
                    $('#detaillokasi').text(e.lokasi || '-');
                    // $('#detailpenilai').text(e.penilaiStr || '-');
                    $('#detailstatus').text(e.statusPenilai);

                    if (e.link && e.link.trim() !== '') {
                        $('#detaillink').removeClass('d-none').attr('href', e.link);
                        $('#detaillinkplaceholder').addClass('d-none');
                    } else {
                        $('#detaillink').addClass('d-none');
                        $('#detaillinkplaceholderr').removeClass('d-none').text('-');
                    }

                    let modal = new bootstrap.Modal($('#modalDetailJadwal')[0]);
                    modal.show();
                }
            });
            calendar.render();
        });
    </script>
@endpush
