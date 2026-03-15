@extends('layouts.app')
@section('breadcrumb', 'Tambbah User')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class = "col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class ="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white ">person_add</i>&nbsp;&nbsp;Tambah User
                            </h5>
                            {{-- <a href="{{ route('users.index') }}" class="btn btn-light btn-sm d-flex align-items-center">
                                <i class="material-symbols-rounded text-sm">arrow_back</i>&nbsp;&nbsp;Kembali
                            </a> --}}
                        </div>
                        <div class="card-body">
                            {{-- ini untuk misalnya ada error salah input atau apa --}}
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
                                <label for="name" class="form-label fw-bold text-secondary">Nama Lengkap</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Nama Lengkap user wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="text" id="name" name="name"
                                    class="form-control border rounded-3 px-3 py-2" value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="email" class="form-label fw-bold text-secondary">Email</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Email harus diisi, format valid, dan belum terdaftar"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="text" id="email" name="email"
                                    class="form-control border rounded-3 px-3 py-2" value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="email" class="form-label fw-bold text-secondary">Role</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Role Wajib diisi, Pilih peran pengguna. Ini menentukan hak akses akun ini."
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <select name="role" id="role"
                                    class="form-select border rounded-3 px-3 py-2">
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role User
                                    </option>
                                    <option value="SuperAdmin" {{ old('role') == 'SuperAdmin' ? 'selected' : '' }}>Super
                                        Admin</option>
                                    <option value="AdminUnit" {{ old('role') == 'AdminUnit' ? 'selected' : '' }}>Admin Unit
                                    </option>
                                    <option value= "StaffUnit" {{ old('role') == 'StaffUnit' ? 'selected' : '' }}>Staff Unit
                                    </option>
                                    <option value= "Mahasiswa" {{ old('role') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa
                                    </option>
                                </select>

                                @error('role')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="status" class="form-label fw-bold text-secondary">Status Akun</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Status Wajib di pilih, pilih status yang tertera"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <select name="status" id="status"
                                    class="form-select border rounded-3 px-3 py-2">
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
                                <a href="{{ route('users.index') }}" class="btn bg-gradient-danger text-white px-4">
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
