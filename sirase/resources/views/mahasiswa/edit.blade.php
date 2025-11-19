@extends('layouts.app')
@section('breadcrumb', 'Edir Mahasiswa')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">
                        @csrf
                        <div
                            class ="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0  text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white">edit</i>&nbsp;&nbsp;Edit Staff</h5>
                            <a href="{{ route('mahasiswa.index') }}" class="btn btn-light btn-sm d-flex align-items-center">
                                <i class="material-symbols-rounded text-sm">arrow_back</i>&nbsp;&nbsp;Kembali
                            </a>
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
                            <div class= "form-group mb-2">
                                <label for="name" class="form-label fw-bold text-secondary">Nama Lengkap</label>
                                <input type="text" class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    value="{{ $mahasiswa->user->name }}" readonly
                                    style="background-color: #f0f0f0; color: #6c757d;">
                            </div>
                            <div class="form-group mb-2">
                                <label for="nrp" name="nrp" class="form-label fw-bold text-secondary">NRP</label>
                                <input type="number" id="nrp" name="nrp" value={{ old('nrp', $mahasiswa->nrp) }}
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan Nrp Mahasiswa">
                                @error('nrp')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="fakultas" class="form-label fw-bold text-secondary">Fakultas Mahasiswa</label>
                                <select name="fakultas" id="fakultas"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2">
                                    <option value="" disabled {{ !$mahasiswa->fakultas ? 'selected' : '' }}>Fakultas
                                        Mahasiswa</option>
                                    @foreach ($fakultasList as $list)
                                        <option value="{{ $list }}"
                                            {{ old('fakultas', $mahasiswa->fakultas) == $list ? 'selected' : '' }}>
                                            {{ $list }}
                                        </option>
                                    @endforeach
                                    @error('fakultas')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="jurusan" class="form-label fw-bold text-secondary">Jurusan Mahasiswa</label>
                                <input type="text" id="jurusan" name="jurusan"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan email anda" value="{{ old('jurusan', $mahasiswa->jurusan) }}">
                                @error('jurusan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="tahunMasuk" name="tahunMasuk" class="form-label fw-bold text-secondary">Tahun
                                    Masuk</label>
                                <input type="year" id="tahunMasuk" name="tahunMasuk"
                                    value="{{ old('tahunMasuk', $mahasiswa->tahunMasuk) }}"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan Tahun Masuk (contoh: 2022)" min="1900"
                                    max="{{ date('Y') }}">
                                @error('tahunMasuk')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="noTelepon" name="noTelepon" class="form-label fw-bold text-secondary">Nomor
                                    Telepon</label>
                                <input type="text" id="noTelepon" name="noTelepon"
                                    value="{{ old('noTelepon', $mahasiswa->noTelepon) }}"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan jurusan Mahasiswa (contoh: 085xxxxxxxxxx)">
                                @error('noTelepon')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
