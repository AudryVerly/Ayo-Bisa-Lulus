@extends('layouts.app')
@section('breadcrumb', 'Master Staff Unit')
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('staff.store') }}" method="POST">
                        @csrf
                        <div class ="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white ">person_add</i>&nbsp;&nbsp;Add Staff
                                Unit
                            </h5>
                            <a href="{{ route('units.index') }}" class="btn btn-light btn-sm d-flex align-items-center">
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
                                <label for="name" class="form-label fw-bold text-secondary">Nama Staff</label>
                                <select name="idUser" id="idUser"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2" required>
                                    <option value="">Pilih User</option>
                                    <optgroup label="Admin Unit">
                                        @foreach ($users->where('role', 'AdminUnit') as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </optgroup>

                                    <optgroup label="Staff Unit">
                                        @foreach ($users->where('role', 'StaffUnit') as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="unit" class="unit"class="form-label fw-bold text-secondary">Masukkan
                                    Unit</label>
                                <select name="idUnit" id="idUnit"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2" required>
                                    <option value="">Pilih Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="jabatan" class="Jabatan"class="form-label fw-bold text-secondary">Masukkan
                                    Jabatan Staff
                                </label>
                                <input type="text" id="jabatan" name="jabatan"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan Jabatan User" required>
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
                                <a href="{{ route('staff.index') }}" class="btn bg-gradient-secondary text-white px-4">
                                    <i class="material-symbols-rounded text-sm">close</i><span
                                        class="align-middle">&nbsp;&nbsp;batal</span>
                                </a>
                            </div>
                            <div class="form-group mb-2">
                                <label for="name" class="form-label fw-bold text-secondary">Nama User</label>
                                <select name="idUser" id="idUser" class="form-select shadow-sm border rounded-3 px-3 py-2" required></select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
