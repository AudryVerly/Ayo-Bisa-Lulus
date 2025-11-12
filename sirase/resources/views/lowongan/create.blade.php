@extends('layouts.app')
@section('breadcrumb', 'Create Lowongan')
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('lowongans.store') }}" method="POST">
                        @csrf
                        <div class ="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white ">work</i>&nbsp;&nbsp;Add Lowongan
                                Unit
                            </h5>
                            <a href="{{ route('lowongans.index') }}" class="btn btn-light btn-sm d-flex align-items-center">
                                <i class="material-symbols-rounded text-sm">arrow_back</i>&nbsp;&nbsp;Kembali
                            </a>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group mb-2">
                                <label for="name" class="form-label fw-bold text-secondary">Judul Lowongan</label>
                                <input type="text" id="judulLowongan" name="judulLowongan"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan judul lowongan"required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="deskripsi" class="form-label fw-bold text-secondary">Deskripsi Lowongan</label>
                                <textarea id="deskripsi" name="deskripsi" class="form-control shadow-sm border rounded-3 px-3 py-2" rows="4"
                                    placeholder="Masukkan deskripsi lowongan secara lengkap" required></textarea>
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
                                    Mampu bekerja tim"
                                    required></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="posisi" class="form-label fw-bold text-secondary">Posisi Lowongan</label>
                                <input type="text" id="posisiLowongan" name="posisiLowongan"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan judul lowongan" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="durasi" class="form-label fw-bold text-secondary">Durasi Kerja (bulan)</label>
                                <input type="text" id="durasiKerja" name="durasiKerja"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan judul lowongan" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="awalPendaftaran" class="form-label fw-bold text-secondary">Awal
                                    Pendaftaran</label>
                                <input type="date" id="awalPendaftaran" name="awalPendaftaran"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="batasPendaftaran" class="form-label fw-bold text-secondary">Batas
                                    Pendaftaran</label>
                                <input type="date" id="batasPendaftaran" name="batasPendaftaran"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="mulaiKerja" class="form-label fw-bold text-secondary">Mulai Kerja</label>
                                <input type="date" id="mulaiKerja" name="mulaiKerja"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="akhirKerja" class="form-label fw-bold text-secondary">Akhir Kerja</label>
                                <input type="date" id="akhirKerja" name="akhirKerja"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2" required>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-success text-white px-4">
                                    <i class="material-symbols-rounded text-sm">save</i><span
                                        class="align-middle">&nbsp;&nbsp;Simpan
                                        Perubahan</span>
                                </button>
                                <a href="{{ route('lowongans.index') }}" class="btn bg-gradient-secondary text-white px-4">
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
