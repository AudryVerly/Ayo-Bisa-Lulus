@extends('layouts.app')
@section('breadcrumb', 'Edit Staff')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('staff.update', $staff->id) }}" method="POST">
                        @csrf
                        <div
                            class ="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0  text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white">edit</i>&nbsp;&nbsp;Edit Staff</h5>
                            {{-- <a href="{{ route('staff.index') }}" class="btn btn-light btn-sm d-flex align-items-center">
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
                                <label for="name" class="form-label fw-bold text-secondary">Nama Lengkap</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Pilih nama staff unit untuk masing-masing unit, wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <select name="idUser" id="idUser"
                                    class="form-select  border rounded-3 px-3 py-2">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('idUser', $staff->idUser) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->role }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idUser')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="Unit" class="form-label fw-bold text-secondary">Nama Unit </label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Pilih unit untuk masing-masing staff, wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <select name="idUnit" id="idUnit"
                                    class="form-select  border rounded-3 px-3 py-2">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('idUnit', $staff->idUnit) == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idUnit')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class = "form-group mb-2">
                                <label for="jabatan" class="form-label fw-bold text-secondary">Jabatan</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Isi dengan benar jabatan staff tersebut, Wajib disii"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="text" id="jabatan" name="jabatan"
                                    class="form-control  border rounded-3 px-3 py-2"
                                    value="{{ old('jabatan', $staff->jabatan) }}">
                            </div>
                            @error('jabatan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-success text-white px-4">
                                    <i class="material-symbols-rounded text-sm">save</i><span
                                        class="align-middle">&nbsp;&nbsp;Simpan</span>
                                </button>
                                <a href="{{ route('staff.index') }}" class="btn bg-gradient-danger text-white px-4">
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
