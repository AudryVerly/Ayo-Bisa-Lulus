@extends('layouts.app')
@section('breadcrumb', 'Create Lowongan')
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('lowongans.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class ="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white ">work</i>&nbsp;&nbsp;Add Lowongan
                                Unit
                            </h5>
                            {{-- <a href="{{ route('lowongans.index') }}" class="btn btn-light btn-sm d-flex align-items-center">
                                <i class="material-symbols-rounded text-sm">arrow_back</i>&nbsp;&nbsp;Kembali
                            </a> --}}
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
                                <input type="text" id="judulLowongan" name="judulLowongan"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan judul lowongan" value ="{{ old('judulLowongan') }}">
                                @error('judulLowongan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="deskripsi" class="form-label fw-bold text-secondary">Deskripsi Lowongan</label>
                                <textarea id="deskripsi" name="deskripsi" class="form-control shadow-sm border rounded-3 px-3 py-2" rows="4"
                                    placeholder="Masukkan deskripsi lowongan secara lengkap">{{old('deskripsi')}}</textarea>
                                @error('deskripsi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- ini kita trim supaya dia mau kebawah dalam bentuk bullet --}}
                            <div class="form-group mb-2">
                                <label for="kualifikasi" class="form-label fw-bold text-secondary">Kualifikasi
                                    Lowongan</label>
                                <small class="text-muted d-block mb-1 small" style="font-size: 0.8rem;">
                                    Gunakan Enter untuk memasukkan poin baru
                                </small>
                                <textarea id="kualifikasi" name="kualifikasi" class="form-control shadow-sm border rounded-3 px-3 py-2" rows="6"
                                    placeholder="Gunakan Enter untuk membuat poin baru, misalnya:
                                        Mahasiswa aktif minimal semester 3
                                        Bisa Microsoft Office
                                        Mampu bekerja tim">{{ old('kualifikasi') }}</textarea>
                                @error('kualifikasi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="posisiLowongan" class="form-label fw-bold text-secondary">Posisi
                                    Lowongan</label>
                                <input type="text" id="posisiLowongan" name="posisiLowongan"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan judul lowongan" value="{{ old('posisiLowongan') }}">
                                @error('posisiLowongan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="durasiKerja" class="form-label fw-bold text-secondary">Durasi Kerja
                                    (bulan)</label>
                                <input type="number" id="durasiKerja" name="durasiKerja"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2 text-dark"
                                    style="background-color: #e0e0e0; color: #6e757b;" readonly
                                    value="{{ old('durasiKerja') }}">
                                @error('durasiKerja')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="awalPendaftaran" class="form-label fw-bold text-secondary">Awal
                                    Pendaftaran</label>
                                <input type="date" id="awalPendaftaran" name="awalPendaftaran"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    value="{{ old('awalPendaftaran') }}">
                                @error('awalPendaftaran')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="batasPendaftaran" class="form-label fw-bold text-secondary">Batas
                                    Pendaftaran</label>
                                <input type="date" id="batasPendaftaran" name="batasPendaftaran"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    value="{{ old('batasPendaftaran') }}">
                                @error('batasPendaftaran')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="mulaiKerja" class="form-label fw-bold text-secondary">Mulai Kerja</label>
                                <input type="date" id="mulaiKerja" name="mulaiKerja"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    value="{{ old('mulaiKerja') }}">
                                @error('mulaiKerja')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="akhirKerja" class="form-label fw-bold text-secondary">Akhir Kerja</label>
                                <input type="date" id="akhirKerja" name="akhirKerja"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    value="{{ old('akhirKerja') }}">
                                @error('akhirKerja')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="poster" class="form-label fw-bold text-secondary">Poster</label>
                                <div class="form-group mb-3">
                                    <img id="posterPreview" src="{{ asset('template/img/noimage.jpg') }}" width="250"
                                        class="rounded shadow-sm mb-2">
                                </div>
                                <input type="file" id="poster" name="poster"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2">
                                @error('poster')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-success text-white px-4">
                                    <i class="material-symbols-rounded text-sm">save</i><span
                                        class="align-middle">&nbsp;&nbsp;Simpan
                                        Perubahan</span>
                                </button>
                                <a href="{{ route('lowongans.index') }}"
                                    class="btn bg-gradient-secondary text-white px-4">
                                    <i class="material-symbols-rounded text-sm">close</i><span
                                        class="align-middle">&nbsp;&nbsp;batal</span>
                                </a>
                            </div>
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
