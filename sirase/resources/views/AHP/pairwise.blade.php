@extends('layouts.app')
@section('breadcrumb', 'AHP Process')

@section('content')
    <div class="container-main">
        <div class="card-custom">
            <h3>Pairwise Comparison Kriteria</h3>
            <p>Geser Slider sesuai dengan keperluan dan seberapa penting kriteria</p>
            @if ($isLocked)
                <div class="alert alert-danger text-white">
                    Tidak bisa mengubah bobot karena masih ada lowongan yang belum mencapai tanggal mulai kerja dan sudah
                    tutup batas pendaftaran.
                </div>
            @endif
            <form id="pairwiseform">
                @php
                    $pairs = [];
                    for ($i = 0; $i < count($kriteria); $i++) {
                        for ($j = $i + 1; $j < count($kriteria); $j++) {
                            $pairs[] = [$kriteria[$i], $kriteria[$j]];
                        }
                    }
                @endphp
                @foreach ($pairs as $index => $pair)
                    <div class="comparison-card">

                        <div class="criterion text-center fw-bold mb-2">
                            {{ $pair[0]->namaKriteria }}
                        </div>

                        <div class="slider-container text-center">

                            <span class="slider-value d-none" id="val{{ $index }}"></span>

                            <input type="range" min="1" max="9" value="1" class="slider"
                                id="slider{{ $index }}" name="comparison[{{ $pair[0]->id }}-{{ $pair[1]->id }}]"
                                {{ $isLocked ? 'disabled' : '' }}>

                            <div class="d-flex justify-content-between mt-2 small text-muted">
                                <span>{{ $pair[0]->namaKriteria }} lebih penting</span>
                                <span>{{ $pair[1]->namaKriteria }} lebih penting</span>
                            </div>

                            <div class="text-center mt-2">
                                <small class="fw-semibold text-primary d-none" id="desc{{ $index }}"></small>
                            </div>

                        </div>

                        <div class="criterion text-center fw-bold mt-2">
                            {{ $pair[1]->namaKriteria }}
                        </div>

                    </div>
                @endforeach
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" id="btnProses" class="btn btn-success" style="width: 15%;"
                        {{ $isLocked ? 'disabled' : '' }}>
                        Proses AHP
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let pairwiseData = @json($pairwise)
    </script>
    <script>
        $(document).ready(function() {
            $('input.slider').each(function() {

                var $slider = $(this);
                var index = $slider.attr('id').replace('slider', '');
                var $val = $('#val' + index);
                let $desc = $('#desc' + index);

                let card = $slider.closest('.comparison-card');
                let kiri = card.find('.criterion').eq(0).text().trim();
                let kanan = card.find('.criterion').eq(1).text().trim();


                let key = $slider.attr('name');
                let match = key.match(/\[(\d+)-(\d+)\]/);

                if (match) {
                    let k1 = match[1];
                    let k2 = match[2];

                    let found = pairwiseData.find(p =>
                        (p.kriteriaAwal == k1 && p.kriteriaPembanding == k2) ||
                        (p.kriteriaAwal == k2 && p.kriteriaPembanding == k1)
                    );

                    // if (found) {
                    //     let value;

                    //     if (found.kriteriaAwal == k1) {
                    //         value = found.nilai;
                    //     } else {
                    //         value = 1 / found.nilai;
                    //     }

                    //     $slider.val(value);
                    // }

                    if (found) {
                        let value = 1;

                        if (found.kriteriaAwal == k1) {
                            value = +found.nilai;
                        } else {
                            value = 10 - (+found.nilai);
                        }

                        if (value < 1) value = 1;
                        if (value > 9) value = 9;

                        $slider.val(value);
                    }
                }

                function getDesc(v) {
                    if (v == 1) return 'Keduanya sama penting';
                    if (v == 2) return kiri + ' sedikit lebih penting dari ' + kanan;
                    if (v == 3) return kiri + ' lebih penting dari ' + kanan;
                    if (v == 4) return kiri + ' cukup lebih penting dari ' + kanan;
                    if (v == 5) return kiri + ' penting dari ' + kanan;
                    if (v == 6) return kiri + ' sangat penting dari ' + kanan;
                    if (v == 7) return kiri + ' jauh lebih penting dari ' + kanan;
                    if (v == 8) return kiri + ' hampir mutlak lebih penting dari ' + kanan;

                    return kiri + ' mutlak lebih penting dari ' + kanan;
                }

                function updateSlider() {
                    let v = +$slider.val();

                    // tampilkan angka & deskripsi dari awal
                    $val.removeClass('d-none');
                    $desc.removeClass('d-none');

                    $val.text(v);
                    $desc.text(getDesc(v));

                    // nilai 1 = netral abu
                    if (v == 1) {
                        $slider.css('background', '#e5e7eb');
                        return;
                    }

                    let percent = ((v - 1) / 8) * 100;

                    // hijau progress
                    $slider.css('background',
                        `linear-gradient(to right,
                        #22c55e ${percent}%,
                        #e5e7eb ${percent}%)`
                    );
                }
                updateSlider();
                $slider.on('input change', function() {
                    updateSlider();
                });
            });

            $('#btnProses').click(function() {
                let data = [];

                $('input.slider').each(function() {
                    let key = $(this).attr('name');
                    let value = +$(this).val();

                    let match = key.match(/\[(\d+)-(\d+)\]/);

                    if (match) {
                        data.push({
                            kriteria1: match[1],
                            kriteria2: match[2],
                            nilai: value
                        });
                    }
                });

                console.log("DATA DIKIRIM: ", data);

                $.ajax({
                    url: '/AHP/store',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: data
                    },
                    success: function(res) {
                        console.log("==== MATRIX ====")
                        console.table(res.matrix);

                        console.log("==== Jumlah Kolom ====")
                        console.log(res.column);

                        console.log("==== NORMALISASI ==== ")
                        console.table(res.normalisasi);

                        console.log("=== BOBOT ===");
                        console.log(res.bobot);

                        console.log("=== TOTAL BOBOT ===");
                        console.log(res.totalBobot);

                        console.log("=== EIGEN ===");
                        console.log(res.eigen);

                        console.log("=== LAMBDA ===");
                        console.log(res.lambda);

                        console.log("=== LAMBDA MAX ===");
                        console.log(res.lambdaMax);

                        console.log("=== CI ===");
                        console.log(res.CI);

                        console.log("=== CR ===");
                        console.log(res.CR);

                        if (!res.isConsistent) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Tidak Konsisten',
                                text: 'CR > 0.1, silakan ubah nilai perbandingan',
                            });
                            return;
                        }

                        if (!res.isBobotValid) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Bobot Tidak Valid',
                                text: 'Total bobot tidak sama dengan 1',
                            });
                            return;
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Perhitungan AHP valid & berhasil disimpan!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat memasukkan bobot.'
                        });
                    }
                })
            });
        })
    </script>
@endpush
