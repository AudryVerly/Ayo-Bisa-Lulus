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
                                <input type="text" name="name" id="name"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan nama lengkap" value="{{ old('name', $unit->name) }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="deskripsi" class="form-label fw-bold text-secondary">Deskripsi Unit</label>
                                <textarea id="deskripsi" name="deskripsi" class="form-control shadow-sm border rounded-3 px-3 py-2" rows="4"
                                    placeholder="Masukkan deskripsi unit secara lengkap"> {{ old('deskripsi',$unit->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="lokasi" class="form-label fw-bold text-secondary">Lokasi Unit</label>
                                <textarea id="lokasi" name="lokasi" class="form-control shadow-sm border rounded-3 px-3 py-2" rows="2"
                                    placeholder="Masukkan alamat unit secara lengkap">{{ old('lokasi',$unit->lokasi) }}</textarea>

                                @error('lokasi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="kontak" class="form-label fw-bold text-secondary">Kontak Unit</label>
                                <input type="text" id="kontak" name="kontak"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan Kontak Unit" value="{{ old('kontak',$unit->kontak) }}" required>
                                @error('kontak')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="emailUnit" class="form-label fw-bold text-secondary">Email Unit</label>
                                <input type="text" id="emailUnit" name="emailUnit"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Email Unit secara lengkap" value= "{{ old('emailUnit',$unit->emailUnit) }}" required>
                                @error('emailUnit')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn bg-gradient-success text-white px-4">
                                    <i class="material-symbols-rounded text-sm">save</i><span
                                        class="align-middle">&nbsp;&nbsp;Simpan
                                        Perubahan</span>
                                </button>
                                <a href="{{ route('units.index') }}" class="btn bg-gradient-danger text-white px-4">
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
