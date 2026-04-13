@extends('layouts.app')
@section('breadcrumb', 'NilaiKinerja')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-5 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-4">
                            <h6 class="text-white text-capitalize m-0">Nilai Kinerja</h6>
                            <button class="btn bg-white text-dark border shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#modaladdkinerja" data-id-unit="{{ $unit->id }}">
                                <i
                                    class="material-symbols-rounded
                                text-sm align-middle text-success">add</i>
                                <span class="align-middle fw-bold">Tambah Tahapan</span>
                            </button>
                        </div>
                    </div>

                    <div class="card-body
                                px-2 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tableKualitasKinerja" class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">No</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Nilai Min</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Nilai Max</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Kategori</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Status</th>
                                        <th class="text-uppercase text-body-secondary text-xxs font-weight-bolder opacity-7"
                                            style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nilaiKinerja as $index => $nilai)
                                        <tr class={{ $low->status == 0 ? 'table-secondary' : '' }}>
                                            <td class="text-sm" style="text-align: center;">{{ $index + 1 }}</td>
                                            <td class="text-sm" style="text-align:center">
                                                {{ $nilai->nilaiMin }}
                                            </td>
                                            <td class="text-sm" style="text-align:center">
                                                {{ $nilai->nilaiMax }}
                                            </td>
                                            <td class="text-sm" style="text-align:center">
                                                {{ $nilai->kategori }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center ">
                                                    @if ($nilai->status == 1)
                                                        <span
                                                            class="badge bg-gradient-success text-white px-3 py-2">Aktif</span>
                                                    @else
                                                        <span
                                                            class="badge bg-gradient-danger text-white px-3 py-2">Non-AKtif</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">

                                                    <a href="" class="btn bg-gradient-info btn-sm text-white">
                                                        Edit
                                                    </a>

                                                    @if ($nilai->status == 1)
                                                        <button class="btn btn-danger btn-sm btn-toggle">
                                                            <i
                                                                class= "material-symbols-rounded text-sm align-middle flex-grow-2">block</i>&nbsp;&nbsp;NonAktifkan
                                                        </button>
                                                    @else
                                                        <button class="btn btn-success btn-sm btn-toggle">
                                                            <i
                                                                class= "material-symbols-rounded text-sm align-middle">check_circle</i>&nbsp;&nbsp;Aktifkan
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    {{-- modal buat add --}}
    <div class="modal fade" id="modaladdkinerja" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    <div
                        class="modal-header d-flex justify-content-between align-items-center bg-dark text-white px-4 py-3">
                        <h5 class="modal-title text-white">Tambah Tahapan</h5>
                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idUnit" id="idUnit">
                        <div class="form-group mb-1">
                            <label for="nilaiMin" class="form-label fw-bold text-secondary">Nilai Minimal</label>
                            <div class="custom-tooltip"
                                data-title="Masukkan nilai minimal,bisa berupa angka atau desimal (contoh: 60 atau 60.5)">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <input type="number" step="0.01" name="nilaiMin"
                                class="form-control border rounded-3 px-3 py-2" min="0" max="100"
                                value="{{ old('nilaiMin') }}">
                            @error('nilaiMin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-1">
                            <label for="nilaiMax" class="form-label fw-bold text-secondary">Nilai Maksimal</label>
                            <div class="custom-tooltip"
                                data-title="Masukkan nilai maksimal,bisa berupa angka atau desimal (contoh: 60 atau 60.5)">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <input type="number" step="0.01" name="nilaiMax"
                                class="form-control border rounded-3 px-3 py-2" min="0" max="100"
                                value="{{ old('nilaiMax') }}">
                            @error('nilaiMax')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-1">
                            <label for="kategori" class="form-label fw-bold text-secondary">Kategori</label>
                            <div class="custom-tooltip"
                                data-title="Masukkan nilai ini masuk dalam kategori yang ditentukan oleh unit">
                                <i class="material-symbols-rounded text-secondary ms-1" style="font-size: 1rem;">info</i>
                            </div>
                            <select id="kategori" name="kategori_select" class="form-select border rounded-3 px-3 py-2">
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="Sangat Buruk"
                                    {{ old('kategori_select') == 'Sangat Buruk' ? 'selected' : '' }}>Sangat Buruk</option>
                                <option value="Buruk" {{ old('kategori_select') == 'Buruk' ? 'selected' : '' }}>Buruk
                                </option>
                                <option value="Cukup" {{ old('kategori_select') == 'Cukup' ? 'selected' : '' }}>Cukup
                                </option>
                                <option value="Baik" {{ old('kategori_select') == 'Baik' ? 'selected' : '' }}>Baik
                                </option>
                                <option value="Sangat Baik"
                                    {{ old('kategori_select') == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                                <option value="lainnya" {{ old('kategori_select') == 'lainnya' ? 'selected' : '' }}>
                                    Lainnya</option>
                            </select>

                            <input type="text" name="kategori" id="kategoriInput"
                                class="form-control shadow-sm border rounded-3 px-3 py-2 mt-2" hidden>
                            @error('kategori')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tableKualitasKinerja').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                    emptyTable: 'Belum ada Nilai Kualitas Kinerja',
                    paginate: {
                        previous: "<",
                        next: ">",
                    }
                },
                lengthMenu: [5, 10, 25, 50, 100],
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }]
            });

            $('#kategori').on('change', function() {
                let value = $(this).val();
                let input = $('#kategoriInput');

                if (value === 'lainnya') {
                    input.removeAttr('hidden');
                    input.prop('required', true);
                    input.val('');
                } else {
                    input.attr('hidden', true);
                    input.prop('required', false);
                    input.val(value);
                }
            });
        });
    </script>
@endpush
