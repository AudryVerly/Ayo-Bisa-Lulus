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
                    $slider.css(
                        'background',
                        `linear-gradient(to right, #10b981 ${percent}%, #e5e7eb ${percent}%)`
                    );
                }
                updateSlider();
                $slider.on('input', updateSlider);
            });
        })
    </script>
@endpush
