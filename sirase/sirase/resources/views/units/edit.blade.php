@extends('layouts.app')
@section('breadcrumb', 'Edit Unit')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('units.update', $unit->id) }}" method="POST">
                        @csrf
                        <div
                            class ="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0  text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white">edit</i>&nbsp;&nbsp;Edit Unit</h5>
                            {{-- <a href="{{ route('units.index') }}" class="btn btn-light btn-sm d-flex align-items-center">
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
                                    title="Nama unit yang terdapat di Universitas Surabaya, Wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="text" name="name" id="name"
                                    class="form-control  border rounded-3 px-3 py-2" value="{{ old('name', $unit->name) }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="deskripsi" class="form-label fw-bold text-secondary">Deskripsi Unit</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Deskripsi yang menggambarkan unit secara lengkap, Wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <textarea id="deskripsi" name="deskripsi" class="form-control  border rounded-3 px-3 py-2" rows="4"> {{ old('deskripsi', $unit->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="lokasi" class="form-label fw-bold text-secondary">Lokasi Unit</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Lokasi Unit tersebut berada, Wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <textarea id="lokasi" name="lokasi" class="form-control  border rounded-3 px-3 py-2" rows="2">{{ old('lokasi', $unit->lokasi) }}</textarea>
                                @error('lokasi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="kontak" class="form-label fw-bold text-secondary">Kontak Unit</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Masukkan Kontak Unit yang dapat dihubungi, Wajib Diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="text" id="kontak" name="kontak"
                                    class="form-control  border rounded-3 px-3 py-2"
                                    value="{{ old('kontak', $unit->kontak) }}">
                                @error('kontak')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="emailUnit" class="form-label fw-bold text-secondary">Email Unit</label>
                                <i class="material-symbols-rounded text-secondary ms-0" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Masukkan Email Unit yang aktif,gunakan format email yang valid, Wajib diisi"
                                    style="font-size: 1rem; cursor: help;">
                                    info
                                </i>
                                <input type="text" id="emailUnit" name="emailUnit"
                                    class="form-control  border rounded-3 px-3 py-2"
                                    value= "{{ old('emailUnit', $unit->emailUnit) }}">
                                @error('emailUnit')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-success text-white px-4">
                                    <i class="material-symbols-rounded text-sm">save</i><span
                                        class="align-middle">&nbsp;&nbsp;Simpan</span>
                                </button>
                                <a href="{{ route('units.index') }}" class="btn bg-gradient-danger text-white px-4">
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
