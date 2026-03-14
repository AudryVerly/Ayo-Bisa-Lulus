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
                            {{-- <a href="{{ route('mahasiswa.index') }}" class="btn btn-light btn-sm d-flex align-items-center">
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
                                <label for="name" class="form-label fw-bold text-secondary">Nama Mahasiswa</label>
                                <select name="idUser" id="idUser"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2">
                                    <option value="">Pilih User</option>
                                    @foreach ($user as $users)
                                        <option value="{{ $users->id }}"
                                            {{ old('idUser') == $users->idUser ? 'selected' : '' }}>{{ $users->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idUser')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="nrp" name="nrp" class="form-label fw-bold text-secondary">NRP</label>
                                <input type="number" id="nrp" name="nrp"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan Nrp Mahasiswa" value="{{ old('nrp') }}">
                                @error('nrp')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="fakultas" name="fakultas"
                                    class="form-label fw-bold text-secondary">Fakultas</label>
                                <select name="fakultas" id="fakultas"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2">
                                    <option value="" disabled {{ old('fakultas') ? '' : 'selected' }}>Fakultas
                                        Mahasiswa</option>

                                    <option value="Fakultas Farmasi"
                                        {{ old('fakultas') == 'Fakultas Farmasi' ? 'selected' : '' }}>Fakultas Farmasi
                                    </option>
                                    <option value="Fakultas Hukum"
                                        {{ old('fakultas') == 'Fakultas Hukum' ? 'selected' : '' }}>Fakultas Hukum</option>
                                    <option value="Fakultas Bisnis"
                                        {{ old('fakultas') == 'Fakultas Bisnis' ? 'selected' : '' }}>Fakultas Bisnis
                                    </option>
                                    <option value="Fakultas Psikologi"
                                        {{ old('fakultas') == 'Fakultas Psikologi' ? 'selected' : '' }}>Fakultas Psikologi
                                    </option>
                                    <option value="Fakultas Teknik"
                                        {{ old('fakultas') == 'Fakultas Teknik' ? 'selected' : '' }}>Fakultas Teknik
                                    </option>
                                    <option value="Fakultas Industri Kreatif"
                                        {{ old('fakultas') == 'Fakultas Industri Kreatif' ? 'selected' : '' }}>Fakultas
                                        Industri Kreatif</option>
                                    <option value="Fakultas Kedokteran"
                                        {{ old('fakultas') == 'Fakultas Kedokteran' ? 'selected' : '' }}>Fakultas
                                        Kedokteran</option>
                                    <option value="Fakultas Bioteknologi"
                                        {{ old('fakultas') == 'Fakultas Bioteknologi' ? 'selected' : '' }}>Fakultas
                                        Bioteknologi</option>
                                </select>
                                @error('fakultas')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="jurusan" name="jurusan"
                                    class="form-label fw-bold text-secondary">Jurusan</label>
                                <input type="text" id="jurusan" name="jurusan"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan jurusan Mahasiswa" value="{{ old('jurusan') }}">
                                @error('jurusan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="tahunMasuk" name="tahunMasuk" class="form-label fw-bold text-secondary">Tahun
                                    Masuk</label>
                                <input type="year" id="tahunMasuk" name="tahunMasuk"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan Tahun Masuk (contoh: 2022)" min="1900"
                                    max="{{ date('Y') }}" value="{{ old('tahunMasuk') }}">
                                @error('tahunMasuk')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="noTelepon" name="noTelepon" class="form-label fw-bold text-secondary">Nomor
                                    Telepon</label>
                                <input type="text" id="noTelepon" name="noTelepon"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan jurusan Mahasiswa (contoh: 085xxxxxxxxxx)"
                                    value="{{ old('noTelepon') }}">
                                @error('noTelepon')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="status" class="form-label fw-bold text-secondary">Status Unit</label>
                                <select name="status" id="status"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2">
                                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>Status Akun
                                    </option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>NonAktif</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-success text-white px-4">
                                    <i class="material-symbols-rounded text-sm">save</i><span
                                        class="align-middle">&nbsp;&nbsp;Simpan
                                        Perubahan</span>
                                </button>
                                <a href="{{ route('mahasiswa.index') }}"
                                    class="btn bg-gradient-danger text-white px-4">
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
