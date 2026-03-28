@extends('layouts.app')
@section('breadcrumb', 'AHP Process')

@section('content')
    <div class="container-main">
        <div class="card-custom">
            <h3>Pairwise Comparison Kriteria</h3>
            <p>Geser Slider sesuai dengan keperluan dan seberapa penting kriteria</p>
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
                        <div class="criterion">{{ $pair[0]->namaKriteria }}</div>
                        <div class="slider-container">
                            <span class="slider-value" id="val{{ $index }}">1</span>
                            <input type="range" min="1" max="9" value="1" class="slider"
                                id="slider{{ $index }}" name="comparison[{{ $pair[0]->id }}-{{ $pair[1]->id }}]">
                        </div>
                        <div class="criterion">{{ $pair[1]->namaKriteria }}</div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" id="btnProses" class="btn btn-success" style="width: 15%;">
                        Proses AHP
                    </button>
                </div>
            </form>
        </div>
        <div class="card-custom mt-4">
            <h4 style="color: black; font-size: 1.1rem; margin-bottom: 15px;">
                Nilai slider 1-9 menunjukkan tingkat kepentingan relatif antara dua kriteria:
            </h4>
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-ahp">
                    <thead class="bg-white text-center text-dark">
                        <tr>
                            <th style="width: 20%; background-color: white; padding: 12px;">Nilai</th>
                            <th>Definisi Kepentingan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><span class="badge-ahp">1</span></td>
                            <td class="text-center">Kedua elemen sama pentingnya</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge-ahp">3</span></td>
                            <td class="text-center">Salah satu elemen sedikit lebih penting</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge-ahp">5</span></td>
                            <td class="text-center">Salah satu elemen jelas lebih penting</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge-ahp">7</span></td>
                            <td class="text-center">Salah satu elemen sangat jelas lebih penting</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge-ahp">9</span></td>
                            <td class="text-center">Salah satu elemen paling penting</td>
                        </tr>
                        <tr>
                            <td class="text-center"><span class="badge-ahp">2,4,6,8</span></td>
                            <td class="text-center">Apabila ragu-ragu antara dua nilai yang berdekatan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('input.slider').each(function() {

                var $slider = $(this);
                var index = $slider.attr('id').replace('slider', '');
                var $val = $('#val' + index);

                function updateSlider() {
                    let v = $slider.val();
                    $val.text(v);

                    let percent = ((v - 1) / 8) * 100;
                    $slider[0].style.background =
                        `linear-gradient(to right, #10b981 ${percent}%, #e5e7eb ${percent}%)`;
                }
                updateSlider();
                $slider.on('input change', updateSlider);
            });

            $('#btnProses').click(function() {
                let data = [];

                $('input.slider').each(function() {
                    let key = $(this).attr('name');
                    let value = parseFloat($(this).val());

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

                        if (res.isConsistent) {
                            console.log("✅ KONSISTEN (CR < 0.1)");
                        } else {
                            console.log("❌ TIDAK KONSISTEN");
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            });
        })
    </script>
@endpush
