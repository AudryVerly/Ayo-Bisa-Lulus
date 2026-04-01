@extends('layouts.app')
@section('breadcrumb', 'Form Nilai')

@section('content')
    <div class="container py-4">
        <h3 class="fw-bold">Form Penilaian</h3>

        <div class="card mt-3 p-3">
            <h5>{{ $data->namaKandidat }}</h5>
            <p>{{ $data->judulLowongan }} - {{ $data->posisiLowongan }}</p>
        </div>

        <form action="" method="POST">
            @csrf

            @foreach ($kriteria as $i => $k)
                @php
                    $key = 'k' . $i;
                @endphp

                <div class="card kriteria-card mt-3 p-3">
                    <div class="fw-bold text-dark">{{ $k->namaKriteria }}</div>
                    <div class="text-muted small">Bobot: {{ $k->nilaiBobot }}</div>

                    <div class="rating-group">
                        @for ($n = 1; $n <= 5; $n++)
                            <input type="radio" id={{ $key }}_{{ $n }}
                                name="nilai[{{ $k->idBobot }}]" value="{{ $n }}"
                                data-bobot="{{ $k->nilaiBobot }}" data-target="{{ $key }}">
                            <label for="{{ $key }}_{{ $n }}">
                                {{ $n }}

                                @if ($n == 1)
                                    <div class="badge-label">Sangat Buruk</div>
                                @elseif($n == 2)
                                    <div class="badge-label">Buruk</div>
                                @elseif ($n == 3)
                                    <div class="badge-label">Cukup</div>
                                @elseif ($n == 4)
                                    <div class="badge-label">Baik</div>
                                @elseif ($n == 5)
                                    <div class="badge-label">Sangat Baik</div>
                                @endif
                            </label>
                        @endfor
                    </div>
                    <small class="d-block mt-2">
                        Hasil: <span id="{{ $key }}" class="hasil">0</span>
                    </small>
                </div>
            @endforeach
            <div class="total-box text-muted mt-3 text-end">
                <h5>Total Nilai: <span id="total">0</span></h5>
            </div>

            <div class="card mt-3 p-3">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="fw-bold text-dark">Catatan Penilai</div>

                    <i class="material-symbols-rounded text-secondary" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Masukkan catatan tentang kandidat, apabila tidak ada bisa memberikan '-'"
                        style="font-size: 1rem; cursor: help;">
                        info
                    </i>
                </div>
                <textarea name="catatan" class="form-control bg-white shadow-sm px-3 py-2" row="3"
                    placeholder="masukkan catatan mengenai kandidat"></textarea>
            </div>

            <div class="text-end mt-3">
                <button class="btn btn-success">Simpan Penilaian</button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.rating-group input[type="radio"]').on('change', function() {
                let nilai = parseInt($(this).val());
                let bobot = parseFloat($(this).data('bobot'));
                let target = $(this).data('target');

                let normal = nilai / 5;
                let hasil = normal * bobot;

                $('#' + target).text(hasil);

                hitungTotal();
            });

            function hitungTotal() {
                let total = 0;

                $('.rating-group input:checked').each(function() {
                    let nilai = parseInt($(this).val());
                    let bobot = parseFloat($(this).data('bobot'));

                    total += (nilai / 5) * bobot;
                });

                $('#total').text(total);
            }
        });
    </script>
@endpush