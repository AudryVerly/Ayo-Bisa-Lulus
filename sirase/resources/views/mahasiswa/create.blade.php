@extends('layouts.app')
@section('breadcrumb', 'Edit Mahasiswa')
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('mahasiswa.store') }}" method="POST">
                        @csrf
                        <div class ="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white ">person_add</i>&nbsp;&nbsp;Add
                                Mahasiswa
                            </h5>
                            <a href="{{ route('mahasiswa.index') }}" class="btn btn-light btn-sm d-flex align-items-center">
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
                                <label for="name" class="form-label fw-bold text-secondary">Nama Mahasiswa</label>
                                <select name="idUser" id="idUser"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2" required>
                                    <option value="">Pilih User</option>
                                    @foreach ($user as $users)
                                        <option value="{{ $users->id }}">{{ $users->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="nrp" name="nrp" class="form-label fw-bold text-secondary">NRP</label>
                                <input type="number" id="nrp" name="nrp"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan Nrp Mahasiswa" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="fakultas" name="fakultas"
                                    class="form-label fw-bold text-secondary">Fakultas</label>
                                <select name="fakultas" id="fakultas"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2" required>
                                    <option value="" disabled selected>Fakultas Mahasiswa</option>
                                    <option value="Fakultas Farmasi">Fakultas Farmasi</option>
                                    <option value="Fakultas Hukum">Fakultas Hukum</option>
                                    <option value="Fakultas Bisnis">Fakultas Bisnis</option>
                                    <option value="Fakultas Psikologi">Fakultas Psikologi</option>
                                    <option value="Fakultas Teknik">Fakultas Teknik</option>
                                    <option value="Fakultas Industri Kreatif">Fakultas Industri Kreatif</option>
                                    <option value="Fakultas Kedokteran">Fakultas Kedokteran</option>
                                    <option value="Fakultas Bioteknologi">Fakultas Bioteknologi</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="jurusan" name="jurusan"
                                    class="form-label fw-bold text-secondary">Jurusan</label>
                                <input type="text" id="jurusan" name="jurusan"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan jurusan Mahasiswa" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="tahunMasuk" name="tahunMasuk" class="form-label fw-bold text-secondary">Tahun
                                    Masuk</label>
                                <input type="number" id="tahunMasuk" name="tahunMasuk"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan Tahun Masuk (contoh: 2022)" min="1900"
                                    max="{{ date('Y') }}" required>
                            </div>
                             <div class="form-group mb-2">
                                <label for="noTelepon" name="noTelepon"
                                    class="form-label fw-bold text-secondary">Nomor Telepon</label>
                                <input type="text" id="noTelepon" name="noTelepon"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan jurusan Mahasiswa (contoh: 085xxxxxxxxxx)" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="status" class="form-label fw-bold text-secondary">Status Unit</label>
                                <select name="status" id="status"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2" required>
                                    <option value="" disabled selected>Status Akun</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">NonAktif</option>
                                </select>
                            </div>
                             <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-success text-white px-4">
                                    <i class="material-symbols-rounded text-sm">save</i><span
                                        class="align-middle">&nbsp;&nbsp;Simpan
                                        Perubahan</span>
                                </button>
                                <a href="{{ route('mahasiswa.index') }}" class="btn bg-gradient-secondary text-white px-4">
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
