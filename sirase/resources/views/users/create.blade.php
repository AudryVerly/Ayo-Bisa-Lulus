@extends('layouts.app')
@section('breadcrumb', 'Create User')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class = "col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div
                            class ="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white d-flex align-items-center"><i class="material-symbols-rounded text-sm text-white ">person_add</i>&nbsp;&nbsp;Add User
                            </h5>
                            <a href="{{ route('users.index') }}" class="btn btn-light btn-sm d-flex align-items-center">
                                <i class="material-symbols-rounded text-sm">arrow_back</i>&nbsp;&nbsp;Kembali
                            </a>
                        </div>
                        <div class="card-body">
                            {{-- ini untuk misalnya ada error salah input atau apa --}}
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
                                <label for="name" class="form-label fw-bold text-secondary">Nama Lengkap</label>
                                <input type="text" id="name" name="name"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email" class="form-label fw-bold text-secondary">Email</label>
                                <input type="text" id="email" name="email"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan Email anda" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email" class="form-label fw-bold text-secondary">Role</label>
                                <select name="role" id="role"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2" required>
                                    <option value="" disabled selected>Pilih Role User</option>
                                    <option value="SuperAdmin">Super Admin</option>
                                    <option value="AdminUnit">Admin Unit</option>
                                    <option value="StaffUnit">Staff Unit</option>
                                    <option value="Mahasiswa">Mahasiswa</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="status" class="form-label fw-bold text-secondary">Status Akun</label>
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
                                <a href="{{ route('users.index') }}" class="btn bg-gradient-secondary text-white px-4">
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
