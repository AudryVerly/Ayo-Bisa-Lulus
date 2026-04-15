@extends('layouts.app')
@section('breadcrumb', 'Tambah Tugas')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('tugas.storeTugas') }}" method="POST">
                        @csrf
                        <div class="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white ">assignment</i>&nbsp;&nbsp; Tambah
                                Tugas
                            </h5>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="idUnit" value="{{ $idUnit }}">
                            <div class="form-group mb-2">
                                <label for="namaTugas" class="form-label fw-bold text-secondary">
                                    Nama Tugas
                                </label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Masukkan nama tugas yang akan diberikan"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="text" id="namaTugas" name="namaTugas"
                                    class="form-control border rounded-3 px-3 py-2" value="{{ old('namaTugas') }}">
                                @error('namaTugas')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="idMahasiswa" class="form-label fw-bold text-secondary">
                                    Nama Mahasiswa
                                </label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Pilih nama mahasiswa yang tertera, wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <select name="idMahasiswa" id="idMahasiswa" class="form-select border rounded-3 px-3 py-2">
                                    <option value="" disabled selected>Pilih Mahasiswa</option>
                                    @foreach ($mahasiswa as $siswa)
                                        <option value="{{ $siswa->idMahasiswa }}"
                                            {{ old('idMahasiswa') == $siswa->idMahasiswa ? 'selected' : ' ' }}>
                                            {{ $siswa->namaMahasiswa }} - {{ $siswa->namaLowongan }}
                                        </option>
                                    @endforeach
                                    @error('idMahasiswa')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="deskripsi" name="deskripsi"
                                    class="form-label fw-bold text-secondary">Deskripsi</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Masukkan deskaripsi yang sesuai "
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <textarea name="deskripsi" id="deskripsi" class="form-control border rounded-3 px-3 py-2" rows="4"
                                    value="{{ old('deskripsi') }}">
                                </textarea>
                                @error('deskripsi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="bobotNilai" name="bobotNilai"
                                    class="form-label fw-bold text-secondary">Nilai</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Masukkan nilai yang akan didapatkan oleh mahasiswa, jika menyelesikan tugas ini"
                                    bisa berupa angka atau desimal (contoh: 60 atau 60.5)
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="number" step="0.01" name="bobotNilai"
                                    class="form-control border rounded-3 px-3 py-2" min="0" max="100"
                                    value="{{ old('bobotNilai') }}">
                                @error('bobotNilai')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="tenggatPengumpulan" name="tenggatPengumpulan"
                                    class="form-label fw-bold text-secondary">Tenggat Pengumpulan</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Masukkan tangga batas pengumpulan tugas yang diberikan"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="date" id="tenggatPengumpulan" name="tenggatPengumpulan"
                                    class="form-control border rounded-3 px-3 py-2"
                                    value="{{ old('tenggatPengumpulan') }}">
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-success text-white px-4">
                                    <i class="material-symbols-rounded text-sm">save</i><span
                                        class="align-middle">&nbsp;&nbsp;Simpan
                                        Perubahan</span>
                                </button>
                                <a href="{{ route('tugas.listtugas',$idUnit) }}" class="btn bg-gradient-danger text-white px-4">
                                    <i class="material-symbols-rounded text-sm">close</i><span
                                        class="align-middle">&nbsp;&nbsp;Batal</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
