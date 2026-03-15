@extends('layouts.app')
@section('breadcrumb', 'Edit Lowongan')

@section('content')
    <div class= 'container-fluid py-4'>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('lowongans.update', $lowongan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div
                            class ="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0  text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white">edit</i>&nbsp;&nbsp;Edit Lowongan
                            </h5>
                        </div>

                        <div class="card-body">
                            {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}
                            <div class="form-group mb-2">
                                <label for="name" class="form-label fw-bold text-secondary">Judul Lowongan</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Awal kerja harus 14 hari dari batas pendaftaran,wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="text" id="judulLowongan" name="judulLowongan"
                                    class="form-control border rounded-3 px-3 py-2"
                                    value="{{ old('judulLowongan', $lowongan->judulLowongan) }}">
                            </div>
                            @error('judulLowongan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group mb-2">
                                <label for="deskripsi" class="form-label fw-bold text-secondary">Deskripsi Lowongan</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Masukkan deskripsi yang jelas mengenai lowongan,wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <textarea id="deskripsi" name="deskripsi" class="form-control border rounded-3 px-3 py-2" rows="4"> {{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- ini kita trim supaya dia mau kebawah dalam bentuk bullet --}}
                            <div class="form-group mb-2">
                                <label for="kualifikasi" class="form-label fw-bold text-secondary">Kualifikasi
                                    Lowongan</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-html="true"
                                    title="Gunakan Enter untuk membuat poin baru, misalnya:<br>
                                            Mahasiswa aktif minimal semester 3 <br>
                                            Bisa Microsoft Office <br>
                                            Mampu bekerja tim"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <small class="text-muted d-block mb-1 small" style="font-size: 0.8rem;">
                                    Gunakan Enter untuk memasukkan poin baru
                                </small>
                                <textarea id="kualifikasi" name="kualifikasi" class="form-control border rounded-3 px-3 py-2" rows="6">{{ old('kualifikasi', trim(old('kualifikasi', $lowongan->kualifikasi))) }}</textarea>
                                @error('kualifikasi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="posisi" class="form-label fw-bold text-secondary">Posisi Lowongan</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Masukkan posisi lowongan yang akan ditempati,wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="text" id="posisiLowongan" name="posisiLowongan"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    value="{{ old('posisiLowongan', $lowongan->posisiLowongan) }}">
                                @error('posisiLowongan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="durasi" class="form-label fw-bold text-secondary">Durasi Kerja (bulan)</label>
                                <input type="text" id="durasiKerja" name="durasiKerja"
                                    class="form-control border rounded-3 px-3 py-2 text-dark"
                                    style="background-color: #e0e0e0; color: #6e757b;" readonly
                                    value="{{ old('durasiKerja', $lowongan->durasiKerja) }}">
                                @error('durasiKerja')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="awalPendaftaran" class="form-label fw-bold text-secondary">Awal
                                    Pendaftaran</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Masukkan awal pendaftaran dimulai,wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="date" id="awalPendaftaran" name="awalPendaftaran"
                                    class="form-control border rounded-3 px-3 py-2"
                                    value="{{ \Carbon\Carbon::parse(old('awalPendaftaran', $lowongan->awalPendaftaran))->format('Y-m-d') }}">
                                @error('awalPendaftaran')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="batasPendaftaran" class="form-label fw-bold text-secondary">Batas
                                    Pendaftaran</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Masukkan batas pendaftaran, batas pendaftaran harus sama dengan awal pendafatran atau setelahnya,wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="date" id="batasPendaftaran" name="batasPendaftaran"
                                    class="form-control border rounded-3 px-3 py-2"
                                    value="{{ \Carbon\Carbon::parse(old('akhirPendaftaran', $lowongan->batasPendaftaran))->format('Y-m-d') }}">
                                @error('batasPendaftaran')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="mulaiKerja" class="form-label fw-bold text-secondary">Mulai Kerja</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Awal kerja harus 14 hari dari batas pendaftaran,wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="date" id="mulaiKerja" name="mulaiKerja"
                                    class="form-control border rounded-3 px-3 py-2"
                                    value="{{ \Carbon\Carbon::parse(old('mulaiKerja', $lowongan->mulaiKerja))->format('Y-m-d') }}">
                                @error('mulaiKerja')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="akhirKerja" class="form-label fw-bold text-secondary">Akhir Kerja</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Akhir kerja setidaknya harus 1 bulan setelah tanggal mulai kerja,wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="date" id="akhirKerja" name="akhirKerja"
                                    class="form-control border rounded-3 px-3 py-2"
                                    value="{{ \Carbon\Carbon::parse(old('akhirKerja', $lowongan->akhirKerja))->format('Y-m-d') }}">
                                @error('akhirKerja')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="form-group mb-3 text-center">
                                <img id="posterPreview"
                                    src="{{ $lowongan->poster ? asset('storage/' . $lowongan->poster) : asset('template/img/noimage.jpg') }}"
                                    width="180"
                                    class="rounded shadow-sm mb-2">
                            </div> --}}

                            <div class="form-group mb-2">
                                <label for="poster" class="form-label fw-bold text-secondary">Poster</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Poster bisa dalam bentu jpg,jpeg dan png, dengan besar maksimum 20MB,wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <div class="form-group mb-3">
                                    <img id="posterPreview"
                                        src="{{ $lowongan->poster ? asset('storage/' . $lowongan->poster) : asset('template/img/noimage.jpg') }}"
                                        width="250" class="rounded shadow-sm mb-2">
                                </div>
                                <input type="file" id="poster" name="poster"
                                    class="form-control border rounded-3 px-3 py-2"
                                    accept="image/jpeg,image/jpg,image/png">
                                @error('poster')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-success text-white px-4">
                                    <i class="material-symbols-rounded text-sm">save</i><span
                                        class="align-middle">&nbsp;&nbsp;Simpan</span>
                                </button>
                                <a href="{{ route('lowongans.index') }}" class="btn bg-gradient-danger text-white px-4">
                                    <i class="material-symbols-rounded text-sm">close</i><span
                                        class="align-middle">&nbsp;&nbsp;Batal</span>
                                </a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#poster').change(function(e) {
                let file = e.target.files[0];

                if (file) {
                    let reader = new FileReader();

                    reader.onload = function(event) {
                        $('#posterPreview').attr('src', event.target.result);
                    }

                    reader.readAsDataURL(file);
                }
            });
        });

        function hitungDurasi() {
            let mulai = $('#mulaiKerja').val()
            let akhir = $('#akhirKerja').val();

            if (mulai && akhir) {
                let tglMulai = new Date(mulai)
                let tglAkhir = new Date(akhir)

                if (tglAkhir >= tglMulai) {
                    let bulan = (tglAkhir.getFullYear() - tglMulai.getFullYear()) * 12 +
                        (tglAkhir.getMonth() - tglMulai.getMonth())

                    let hari = tglAkhir.getDate() - tglMulai.getDate()

                    let durasi = bulan + (hari / 30)

                    $('#durasiKerja').val(durasi.toFixed(1))
                } else {
                    $('#durasiKerja').val('')
                }
            }
        }

        $(document).ready(function() {

            hitungDurasi()

            $('#mulaiKerja, #akhirKerja').on('change', hitungDurasi)

        })
    </script>
@endpush
