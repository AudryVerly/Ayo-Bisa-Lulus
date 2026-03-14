@extends('layouts.app')
@section('breadcrumb', 'Create Unit')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0 rounded-3">
                    <form action="{{ route('units.store') }}" method="POST">
                        @csrf
                        <div class ="card-header bg-gradient-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white d-flex align-items-center"><i
                                    class="material-symbols-rounded text-sm text-white ">add_home</i>&nbsp;&nbsp;Add Unit
                            </h5>
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
                                <label for="name" class="form-label fw-bold text-secondary">Nama Unit</label>
                                <input type="text" id="name" name="name"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan nama Unit" value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="deskripsi" class="form-label fw-bold text-secondary">Deskripsi Unit</label>
                                <textarea id="deskripsi" name="deskripsi" class="form-control shadow-sm border rounded-3 px-3 py-2" rows="4"
                                    placeholder="Masukkan deskripsi unit secara lengkap" value="{{ old('deskripsi') }}">
                                </textarea>
                                @error('deskripsi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="lokasi" class="form-label fw-bold text-secondary">Lokasi Unit</label>
                                <textarea id="lokasi" name="lokasi" class="form-control shadow-sm border rounded-3 px-3 py-2" rows="2"
                                    placeholder="Masukkan alamat unit secara lengkap" value ="{{ old('lokasi') }}">
                                </textarea>
                                @error('lokasi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="kontak" class="form-label fw-bold text-secondary">Kontak Unit</label>
                                <input type="text" id="kontak" name="kontak"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Masukkan Kontak Unit" value="{{ old('kontak') }}">
                                @error('kontak')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="emailUnit" class="form-label fw-bold text-secondary">Email Unit</label>
                                <input type="text" id="emailUnit" name="emailUnit"
                                    class="form-control shadow-sm border rounded-3 px-3 py-2"
                                    placeholder="Email Unit secara lengkap" value="{{ old('emailUnit') }}">

                                @error('emailUnit')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="status" class="form-label fw-bold text-secondary">Status Unit</label>
                                <select name="status" id="status"
                                    class="form-select shadow-sm border rounded-3 px-3 py-2">
                                    <option value="" disabled {{ old('status') ? '' : 'selected'}}>Status Akun</option>
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
